<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Obra;
use App\Model\TipoSaida;
use App\Model\Funcionario;
use App\Model\Almoxarifado;
use App\Model\SaidaEstoque;
use App\Model\StatusObra;
use App\Model\TipoMaterial;
use App\Model\SaidaMaterialEstoque;
use App\Model\Estoque;
use App\Model\EntradaEstoque;
use App\Model\TransferenciaEstoque;
use App\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\RegistroHistoricoObra;


class SaidaEstoqueController extends Controller
{
    public function index()
    {
        return view('pages.saida-estoque.index');
    }

    public function create()
    {
        $this->authorize('CADASTRAR_SAIDA_ESTOQUE');
        $obras         = Obra::all()->toArray();
        $tipoSaidas    = TipoSaida::all()->toArray();
        $funcionarios  = Funcionario::select('id',\DB::raw("CONCAT(nome, ' ' ,sobrenome) as nome"))->where('conferente', true)->get()->toArray();
        $tipoMateriais = TipoMaterial::select('id',\DB::raw("CONCAT(codigo, ' - ', descricao) as descricao"))->get()->toArray();
        
        return view('pages.saida-estoque.cadastro', compact('obras', 'tipoSaidas', 'funcionarios', 'tipoMateriais'));
    }

    public function store(Request $request)
    {
        $this->authorize('CADASTRAR_SAIDA_ESTOQUE');
        $itensConferidos = $request->input('saidaEstoqueConferido');

        if($itensConferidos['materiais']){
            try {
                
                \DB::transaction(function () use ($request, $itensConferidos) {
                    $headObs = \Auth::user()->name . ' ['. date('d/m/Y H:i') . ']: ';

                    $materiaisConferidos = $itensConferidos['materiais'];
                                
                    $saidaEstoque = new SaidaEstoque();
                    $saidaEstoque->obra_id                      = $itensConferidos['obra_id'];
                    $saidaEstoque->usuario_id                   = \Auth::user()->id;
                    $saidaEstoque->almoxarifado_id              = $itensConferidos['almoxarifado_id'];
                    $saidaEstoque->funcionario_conferente_id    = $itensConferidos['funcionario_conferente_id'];
                    $saidaEstoque->tipo_saida_estoque_id        = $itensConferidos['tipo_saida_estoque_id'];
                    $saidaEstoque->data                         = dateToSave($itensConferidos['data']);
                    $saidaEstoque->execucao                     = dateToSave($itensConferidos['execucao']);
                    $saidaEstoque->obs                          = $headObs . $itensConferidos['obs'];

                    $saidaEstoque->save();

                    foreach ($materiaisConferidos as $row) {
                        $material = TipoMaterial::where('codigo', $row['codigo_material'])->first();
                        if (!$material){
                            throw new \Exception('Atenção! Favor verificar se todos os materiais listados abaixo estão cadastrados.');
                        }
                        $verificarEstoque = Estoque::where('tipo_material_id', $material->id)
                                                   ->where('obra_id', $saidaEstoque->obra_id)
                                                   ->where('almoxarifado_id', $itensConferidos['almoxarifado_id'])
                                                   ->select(\DB::raw('SUM(qtde) as qtde'))
                                                   ->first();

                        if($verificarEstoque->qtde - $row['quantidade'] < 0){
                            throw new \Exception('Existe(m) material(ais) com saldo negativo.');
                        }else{
                            $estoque = new SaidaMaterialEstoque();
                            $estoque->saida_estoque_id = $saidaEstoque->id;
                            $estoque->tipo_material_id = $material->id;
                            $estoque->qtde = $row['quantidade'];
                            $estoque->save();
                        }

                    }
                    RegistroHistoricoObra::registerHistorico(Obra::find($saidaEstoque->obra_id),'Saída de Estoque realizada');

                });

                \DB::commit();
                return response()->json(['success' => true, 'msg' => 'Saída realizada com sucesso.']);

            } catch (\Exception $e) {
                \DB::rollback();
                return response()->json(['success' => false, 'msg' => $e->getMessage()]);
            }
        }
    }

    public function storeVariasObras(Request $request)
    {
        $arraySaved = [];

        $this->authorize('CADASTRAR_SAIDA_ESTOQUE');
        $itensConferidos = $request->input('saidaEstoqueConferido');

        if($itensConferidos['materiais']){
            try {
                \DB::transaction(function () use ($request, $itensConferidos, $arraySaved) {

                    $materiaisConferidos = $itensConferidos['materiais'];

                    foreach ($materiaisConferidos as $row) {
                        $material = TipoMaterial::where('codigo', $row['codigo_material'])->first();
                        $obra = Obra::where('numero_obra', $row['num_obra'])->first();

                        if ($obra){
                            $validarObraAl = Estoque::where('obra_id', $obra->id)->where('almoxarifado_id', $itensConferidos['almoxarifado_id'])->first();
                            if ($validarObraAl){
                                if(!$material) {
                                    throw new \Exception('Atenção! Favor verificar se todos os materiais listados abaixo estão cadastrados.');
                                }else{
                                    if (!in_array($row['num_obra'], $arraySaved)){
                                        $saidaEstoque = new SaidaEstoque();
                                        $saidaEstoque->obra_id                      = $obra->id;
                                        $saidaEstoque->usuario_id                   = \Auth::user()->id;
                                        $saidaEstoque->almoxarifado_id              = $itensConferidos['almoxarifado_id'];
                                        $saidaEstoque->funcionario_conferente_id    = $itensConferidos['funcionario_conferente_id'];
                                        $saidaEstoque->tipo_saida_estoque_id        = $itensConferidos['tipo_saida_estoque_id'];
                                        $saidaEstoque->data                         = dateToSave($itensConferidos['data']);
                                        $saidaEstoque->obs                          = $itensConferidos['obs'];
                                        $saidaEstoque->save();

                                        foreach ($materiaisConferidos as $matObraSeve){
                                            if ($matObraSeve['num_obra'] == $row['num_obra']) {
                                                $mat = TipoMaterial::where('codigo', $matObraSeve['codigo_material'])->first()->id;

                                                $verificarEstoque = Estoque::where('tipo_material_id', $mat)
                                                    ->where('obra_id', $saidaEstoque->obra_id)
                                                    ->where('almoxarifado_id', $itensConferidos['almoxarifado_id'])
                                                    ->select(\DB::raw('SUM(qtde) as qtde'))
                                                    ->first();

                                                if($verificarEstoque->qtde - $matObraSeve['quantidade'] < 0){
                                                    throw new \Exception('Existe(m) material(ais) com saldo negativo.');
                                                }else{
                                                    $estoque = new SaidaMaterialEstoque();
                                                    $estoque->saida_estoque_id = $saidaEstoque->id;
                                                    $estoque->tipo_material_id = $mat;
                                                    $estoque->qtde = $matObraSeve['quantidade'];
                                                    $estoque->save();
                                                }

                                                array_push($arraySaved, $row['num_obra']);
                                            }
                                        }
                                    }
                                }
                            } else {
                                throw new \Exception('Atenção! Favor verificar se todos as obras abaixo possuem materiais no almoxarifado informado.');
                            }
                        } else{
                            throw new \Exception('Atenção! Favor verificar se todos as obras listadas abaixo estão cadastradas.');
                        }
                    }
                    RegistroHistoricoObra::registerHistorico(Obra::find($saidaEstoque->obra_id),'Saída de Estoque realizda.');
                });

                \DB::commit();
                return response()->json(['success' => true, 'msg' => 'Saída realizada com sucesso.']);

            } catch (\Exception $e) {
                \DB::rollback();
                return response()->json(['success' => false, 'msg' => $e->getMessage()]);
            }
        }
    }

    public function obterUnidadeMedida(Request $request)
    {
        $result = TipoMaterial::where('id', $request->input('idMaterial'))->first();
        
        return response()->json(['success' => true, 'unidadeMedida' => $result->unidade->codigo, 'codigo' => $result->codigo, 'ponto_flutuante' => $result->unidade->ponto_flutuante ]);
    }

    public function conferirSaidaEstoque(Request $request)
    {
        $id                 = $request->input('id');
        $materiais          = json_decode($request->input('materiais'));
        $saidaEstoque       = SaidaEstoque::find($id);
        $arquivo            = $request->file('arquivo');
        $obra_id            = $request->input('obra_id');
        $almoxarifado_id    = $request->input('almoxarifado_id');
        $metodo_entrada     = $request->input('metodo_entrada');
        $materiaisAux       = [];
        
        if(!$saidaEstoque){
            $saidaEstoque = new SaidaEstoque();
        }

        $saidaEstoque->fill($request->all());
        $saidaEstoque->materiais = $materiais;

        $validade = null;
        if($metodo_entrada == 3) {
            $validade = validator($request->all(), $saidaEstoque->rulesVariasObras(), $saidaEstoque->msgRulesVariasObras);
        } else{
            $validade = validator($request->all(), $saidaEstoque->rules(), $saidaEstoque->msgRules);
        }

        if($validade->fails()) {
            return response()->json(['success' => false, 'msg' => arrayToValidator($validade->getMessageBag())]);
        }

        if($metodo_entrada == 3) {
            try {
                if($arquivo){
                    $dados = Excel::load($arquivo, function ($reader) {
                    })->toObject();

                    foreach ($dados as $row) {
                        $existe = '';
                        $obraExiste = '';
                        $obraAlExiste = ''; //verifica se existe registro da obra e do almoxarifado
                        $qtdeEstoque = 0;

                        //Verifica se nenhum dado da planinha é negativo
                        if ($row->qtdatd_num_obra == null || $row->qtdatd_num_obra <= 0 || $row->numobra == null) {
                            return response()->json(['success' => false, 'msg' => 'Valores negativos ou nulos na planinha, favor verificar.']);
                        }

                        if(!empty($row->codmat_mov) && !empty($row->dscmat) && !empty($row->numobra)){
                            $row->dscmat = str_replace('"', "'", $row->dscmat);

                            $validarMaterial    = TipoMaterial::where('codigo', $row->codmat_mov)->first();
                            $validarObra        = Obra::where('numero_obra', $row->numobra)->first();

                            if (!$validarObra){
                                $obraExiste = 'n';
                                $obraAlExiste = 'n';
                            }else{
                                $validarObraAl = Estoque::where('obra_id', $validarObra->id)->where('almoxarifado_id', $almoxarifado_id)->first();
                                if(!$validarObraAl)
                                    $obraAlExiste = 'n';
                            }

                            if(!$validarMaterial){
                                $existe = 'n';
                            }

                            if($obraAlExiste != 'n' && $validarMaterial){
                                $estoque = Estoque::where('tipo_material_id', $validarMaterial->id)
                                    ->where('obra_id', $validarObra->id)
                                    ->where('almoxarifado_id', $almoxarifado_id)
                                    ->select(\DB::raw('SUM(qtde) as qtde'))
                                    ->first();

                                if(isset($estoque) && count($estoque) > 0){
                                    $qtdeEstoque = $estoque->qtde;
                                }
                            }

                            array_push($materiaisAux, [
                                'num_obra' => $row->numobra,
                                'codigo_material' => $row->codmat_mov,
                                'descricao' => $row->codmat_mov.' - '.$row->dscmat,
                                'descricao_original' => $row->dscmat,
                                'quantidade' => $row->qtdatd_num_obra,
                                'existe' => $existe,
                                'obraExiste' => $obraExiste,
                                'obraAlExiste' => $obraAlExiste,
                                'qtdeEstoque' => $qtdeEstoque]
                            );
                        }else{
                            throw new \PHPExcel_Reader_Exception();
                        }
                    }

                    sort($materiaisAux);
                    $materiaisAux = json_encode($materiaisAux);
                    $saidaEstoque->materiais = json_decode($materiaisAux);
                }else{
                    return response()->json(['success' => false, 'msg' => 'Nenhum arquivo encontrado.']);
                }
            } catch (\PHPExcel_Reader_Exception $e) {
                return response()->json(['success' => false, 'msg' => 'Favor verificar o modelo do excel.']);
            }
        } elseif($metodo_entrada == 2){
            try {
                if($arquivo){
                    $dados = Excel::load($arquivo, function ($reader) {
                    })->toObject();

                    foreach ($dados as $row) {
                        $existe = '';
                        $qtdeEstoque = 0;
                        //Verifica se nenhum dado da planinha é negativo
                        if ($row->rma == null && $row->rma == null || $row->rma <= 0) {
                           return response()->json(['success' => false, 'msg' => 'Valores negativos ou nulos na planinha, favor verificar.']); 
                        }

                        if(!empty($row->codigo) && !empty($row->descricao)){

                            $row->descricao = str_replace('"', "'", $row->descricao);
                            
                            $validarMaterial = TipoMaterial::where('codigo', $row->codigo)->first();
                            
                            if(count($validarMaterial) == 0){
                                $existe = 'n';
                            }else{
                                //busca a quantidade do material no estoque.
                                $estoque = Estoque::where('tipo_material_id', $validarMaterial->id)
                                                 ->where('obra_id', $saidaEstoque->obra_id)
                                                 ->where('almoxarifado_id', $almoxarifado_id)
                                                 ->select(\DB::raw('SUM(qtde) as qtde'))
                                                 ->first();
                                
                                if(isset($estoque) && count($estoque) > 0){
                                    $qtdeEstoque = $estoque->qtde;
                                }
                            }

                            array_push($materiaisAux, ['codigo_material' => $row->codigo, 
                                                         'descricao' => $row->codigo.' - '.$row->descricao, 
                                                         'descricao_original' => $row->descricao,
                                                         'quantidade' => $row->rma, 
                                                         'existe' => $existe,
                                                         'qtdeEstoque' => $qtdeEstoque]);
                        }else{
                            throw new \PHPExcel_Reader_Exception();
                        }
                    }
                    $materiaisAux = json_encode($materiaisAux);
                    $saidaEstoque->materiais = json_decode($materiaisAux);
                    
                }else{
                    return response()->json(['success' => false, 'msg' => 'Nenhum arquivo encontrado.']);
                }
            } catch (\PHPExcel_Reader_Exception $e) {
                return response()->json(['success' => false, 'msg' => 'Favor verificar o modelo do excel.']);
            }
        } elseif($metodo_entrada = 1){
            //Saída Manual
            if(!empty($materiais)){

                foreach ($materiais as $row) {
                    $validarMaterial = TipoMaterial::where('codigo', $row->codigo_material)->first();
                    //busca a quantidade do material no estoque.
                    $estoque = Estoque::where('tipo_material_id', $validarMaterial->id)
                                             ->where('obra_id', $obra_id)
                                             ->where('almoxarifado_id', $almoxarifado_id)
                                             ->select(\DB::raw('SUM(qtde) as qtde'))
                                             ->first();

                    $qtdeEstoque = $estoque->qtde > 0 ? $estoque->qtde : 0;

                    array_push($materiaisAux, ['codigo_material' => $row->codigo_material,
                                               'descricao' => $row->descricao,
                                               'descricao_original' => $validarMaterial->descricao,
                                               'quantidade' => $row->quantidade,
                                               'qtdeEstoque' => $qtdeEstoque]);
                }

                $materiaisAux = json_encode($materiaisAux);
                $saidaEstoque->materiais = json_decode($materiaisAux);
            }else{
                return response()->json(['success' => false, 'msg' => 'Materiais não preenchido.']);
            }
        }

        if ($metodo_entrada == 3){
            return view('pages.saida-estoque.conferir-varias-obras', compact('saidaEstoque'));
        } else{
            return view('pages.saida-estoque.conferir', compact('saidaEstoque'));
        }
    }

    public function gerenciador(Request $request)
    {
        $this->authorize('CONSULTAR_SAIDA_ESTOQUE');

        $users          = User::join('saida_estoque AS saida', 'saida.usuario_id', '=', 'users.id')->select('users.id', 'users.name')->get()->toArray();
        $funcionario    = Funcionario::join('saida_estoque AS saida', 'saida.funcionario_conferente_id', '=', 'funcionarios.id')->select('funcionarios.id',\DB::raw("CONCAT(funcionarios.nome, ' ' ,funcionarios.sobrenome) as nome"))->get()->toArray();
        $obra           = Obra::join('saida_estoque AS saida', 'saida.obra_id', '=', 'obra.id')->select('obra.id', 'obra.numero_obra')->get()->toArray();
        $tipoSaida      = TipoSaida::all()->toArray();
        $almoxarifados  = Almoxarifado::all()->toArray();
        $saidaEstoque   = SaidaEstoque::filterSaidaEstoque($request->all())->orderByRaw('data DESC, created_at ASC')->paginate(10)->setPath('')->appends($request->query());

        return view('pages.saida-estoque.gerenciador', compact('users', 'funcionario', 'obra', 'tipoSaida', 'saidaEstoque', 'almoxarifados'));
    }

    public function pesquisa(Request $request)
    {
        $almoxarifado  = Almoxarifado::all()->toArray();
        $tipo_material = Estoque::join('tipo_material as tipo', 'tipo.id', '=', 'estoque.tipo_material_id')->get()->toArray();
        $status_obra   = StatusObra::all()->toArray();

        if($request->all()){
            $estoque = SaidaEstoque::filterPesquisaEstoque($request->all())->orderBy('id')->paginate(10);
        }else{
            $estoque = Estoque::orderBy('id')->paginate(10);
        }

        return view('pages.saida-estoque.pesquisa', compact('estoque','almoxarifado', 'tipo_material', 'status_obra'));
    }

    public function exportarExcel(Request $request)
    {
        $this->authorize('EXPORTAR_CONSULTA_SAIDA_ESTOQUE');
        $data = SaidaEstoque::filterSaidaEstoque($request->all());
        $dataAtual = date('Y-m-d_H:i');
        $data = $data->select('obra.numero_obra as numero_obra','user.name as usuario','alm.nome as almoxarifado', \DB::RAW("CONCAT(func.nome, ' ' , func.sobrenome) as \"conferente\""), 'saida.nome as tipo_saida', \DB::RAW("TO_CHAR(saida_estoque.data,'DD/MM/YYYY') as \"data\""), \DB::RAW("TO_CHAR(saida_estoque.execucao,'DD/MM/YYYY') as \"execucao\""), 'saida_estoque.obs as observacao')
                     ->join('obra as obra', 'obra.id','=','saida_estoque.obra_id')
                     ->join('users as user', 'user.id','=','saida_estoque.usuario_id')
                     ->join('almoxarifado as alm', 'alm.id','=','saida_estoque.almoxarifado_id')
                     ->join('funcionarios as func', 'func.id','=','saida_estoque.funcionario_conferente_id')
                     ->join('tipo_saida as saida', 'saida.id','=','saida_estoque.tipo_saida_estoque_id')
                     ->orderBy('saida_estoque.id')->get()->toArray();

        $excel = \Excel::create('Saída_Estoque_'.$dataAtual, function($excel) use ($data) {
            $excel->sheet('Plan 1', function($sheet) use ($data)
            {
                $sheet->cell('A2:H2', function($cell) {
                    $cell->setFontWeight('bold');
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setBackground('#FFFFFF');
                });

                $sheet->cell('A:H', function($cell) {
                    $cell->setValignment('center');
                });

                $sheet->mergeCells('A1:H1');
                $sheet->setHeight(1, 53);
                $sheet->setBorder('A2:H2', 'thin');
                
                $file = \File::allFiles(public_path().'/storage/imagens/empresa/');
                if(count($file) > 0){
                    $imageToExcel = new \PHPExcel_Worksheet_Drawing;
                    $imageToExcel->setName('Logo');
                    $imageToExcel->setDescription('Logo');
                    $imageToExcel->setPath($file[0]->getRealPath());
                    $imageToExcel->setHeight(70); 
                    $imageToExcel->setCoordinates('A1');
                    $imageToExcel->setWorksheet($sheet);
                }
                $sheet->setCellValue('A2', 'Nº Obra');
                $sheet->setCellValue('B2', 'Usuário');
                $sheet->setCellValue('C2', 'Almoxarifado');
                $sheet->setCellValue('D2', 'Conferente');
                $sheet->setCellValue('E2', 'Tipo Saída');
                $sheet->setCellValue('F2', 'Data');
                $sheet->setCellValue('G2', 'Prev. Execução');
                $sheet->setCellValue('H2', 'Observação');
                $sheet->setHeight(2, 40.5);
                $sheet->getStyle('H1:H9999')->getAlignment()->setWrapText(true);
                $sheet->setAutoSize(array(
                    'A', 'B', 'C', 'D', 'E', 'F', 'G'
                ));
                $sheet->setWidth(array(
                    'H'     =>  75
                ));

                for ($iRow = 3; $iRow < count($data) + 3; $iRow++){
                    $sheet->setCellValue('A' . $iRow, $data[$iRow-3]['numero_obra']);
                    $sheet->setCellValue('B' . $iRow, $data[$iRow-3]['usuario']);
                    $sheet->setCellValue('C' . $iRow, $data[$iRow-3]['almoxarifado']);
                    $sheet->setCellValue('D' . $iRow, $data[$iRow-3]['conferente']);
                    $sheet->setCellValue('E' . $iRow, $data[$iRow-3]['tipo_saida']);
                    $sheet->setCellValue('F' . $iRow, $data[$iRow-3]['data']);
                    $sheet->setCellValue('G' . $iRow, $data[$iRow-3]['execucao']);
                    $sheet->setCellValue('H' . $iRow, $data[$iRow-3]['observacao']);
                }
            });
        })->string('xlsx');

        $response =  array(
            'success' => true,
            'name' => "Saída_Estoque_".$dataAtual.".xlsx",
            'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,".base64_encode($excel)
        );

        return response()->json($response);
    }

    public function exportarPdf(Request $request)
    {
        $this->authorize('EXPORTAR_CONSULTA_SAIDA_ESTOQUE');
        $titulo = "Saída Estoque";
        $result = SaidaEstoque::filterSaidaEstoque($request->all())->get();
        $name   = "Saida_Estoque_".date('Y-m-d_H-i');
        $route  = 'pages.saida-estoque.export-pdf';
        
        if(count($result) == 0){
            notify()->flash('Não foi possível Gerar o PDF.', 'danger');
            return back()->withInput();
        }else{
            return exportPdf($titulo, $result, $name, $route, 'landscape');
        }
    }


    //=== SELECIONAR ALMOXARIFADO CONFORME NÚMERO DA OBRA ===//
    public function almoxarifado($idObra)
    {
        $union = TransferenciaEstoque::join('almoxarifado as alm', 'alm.id', '=', 'transferencia_estoque.almoxarifado_destino_id')
                                    ->where('transferencia_estoque.obra_destino_id', $idObra)
                                    ->select('alm.id as id','alm.nome as nome')
                                    ->groupBy('alm.id');


        $almoxarifado = EntradaEstoque::join('almoxarifado as alm', 'alm.id', '=', 'entrada_estoque.almoxarifado_id')
                                      ->where('entrada_estoque.obra_id', $idObra)
                                      ->select('alm.id as id','alm.nome as nome')
                                      ->union($union)
                                      ->groupBy('alm.id');

        return $almoxarifado->orderBy('nome')->get();
    }

    public function almoxarifadoAll()
    {
        $union = TransferenciaEstoque::join('almoxarifado as alm', 'alm.id', '=', 'transferencia_estoque.almoxarifado_destino_id')
            ->select('alm.id as id','alm.nome as nome')
            ->groupBy('alm.id');

        $almoxarifado = EntradaEstoque::join('almoxarifado as alm', 'alm.id', '=', 'entrada_estoque.almoxarifado_id')
            ->select('alm.id as id','alm.nome as nome')
            ->union($union)
            ->groupBy('alm.id');

        return $almoxarifado->orderBy('nome')->get();
    }
}