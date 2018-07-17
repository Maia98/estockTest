<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Model\Obra;
use App\Model\TipoEntrada;
use App\Model\Funcionario;
use App\Model\Almoxarifado;
use App\Model\Empresa;
use App\Model\EntradaEstoque;
use App\Model\TipoMaterial;
use App\Model\EntradaMaterialEstoque;
use App\Model\Estoque;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\RegistroHistoricoObra;


class EntradaEstoqueController extends Controller
{
    public function index()
    {
        return view('pages.entrada-estoque.index');
    }

    public function create()
    {
        $this->authorize('CADASTRAR_ENTRADA_ESTOQUE');

        $obras = Obra::all()->toArray();
        $tipoEntradas = TipoEntrada::all()->toArray();
        $funcionarios = Funcionario::select('id',\DB::raw("CONCAT(nome, ' ', sobrenome) as nome"))->where('conferente', true)->get()->toArray();
        $almoxarifados = Almoxarifado::all()->toArray();
        $tipoMateriais = TipoMaterial::select('id',\DB::raw("CONCAT(codigo, ' - ', descricao) as descricao"))->get()->toArray();
        
        return view('pages.entrada-estoque.cadastro', compact('obras', 'tipoEntradas', 'funcionarios', 'almoxarifados', 'tipoMateriais'));
    }

    public function store(Request $request)
    {
        $this->authorize('CADASTRAR_ENTRADA_ESTOQUE');
        $itensConferidos = $request->input('entradaEstoqueConferido');

        if($itensConferidos['materiais']){
            try {
                
                \DB::transaction(function () use ($request, $itensConferidos) {

                    $materiaisConferidos = $itensConferidos['materiais'];
                                
                    $entradaEstoque = new EntradaEstoque();
                    $entradaEstoque->obra_id                        = $itensConferidos['obra_id'];
                    $entradaEstoque->usuario_id                     = \Auth::user()->id;
                    $entradaEstoque->almoxarifado_id                = $itensConferidos['almoxarifado_id'];
                    $entradaEstoque->funcionario_conferente_id      = $itensConferidos['funcionario_conferente_id'];
                    $entradaEstoque->tipo_entrada_estoque_id        = $itensConferidos['tipo_entrada_estoque_id'];
                    $entradaEstoque->data                           = dateToSave($itensConferidos['data']);
                    $entradaEstoque->obs                            = $itensConferidos['obs'];
                    $entradaEstoque->save();

                    foreach ($materiaisConferidos as $row) {
                        $material = TipoMaterial::where('codigo', $row['codigo_material'])
                                                ->first();
                        if(count($material) == 0) {
                            throw new \Exception('Atenção! Favor verificar se todos os materiais listados abaixo estão cadastrados.');
                        }else{
                            $estoque = new EntradaMaterialEstoque();
                            $estoque->entrada_estoque_id = $entradaEstoque->id;
                            $estoque->tipo_material_id = $material->id;
                            $estoque->qtde = $row['quantidade'];
                            $estoque->save();
                        }
                    }

                    RegistroHistoricoObra::registerHistorico(Obra::find($entradaEstoque->obra_id),'Entrada de Estoque realizda');
                }); 

                \DB::commit();
                return response()->json(['success' => true, 'msg' => 'Entrada realizada com sucesso.']);

            } catch (\Exception $e) {
                \DB::rollback();
                return response()->json(['success' => false, 'msg' => $e->getMessage()]);
            }
        }
    }

    public function storeVariasObras(Request $request)
    {
        $arraySaved = [];

        $this->authorize('CADASTRAR_ENTRADA_ESTOQUE');
        $itensConferidos = $request->input('entradaEstoqueConferido');

        if($itensConferidos['materiais']){
            try {

                \DB::transaction(function () use ($request, $itensConferidos, $arraySaved) {

                    $materiaisConferidos = $itensConferidos['materiais'];

                    foreach ($materiaisConferidos as $row) {
                        $material = TipoMaterial::where('codigo', $row['codigo_material'])->first();
                        $obra = Obra::where('numero_obra', $row['num_obra'])->first();

                        if ($obra){
                            if(!$material) {
                                throw new \Exception('Atenção! Favor verificar se todos os materiais listados abaixo estão cadastrados.');
                            }else{
                                if (!in_array($row['num_obra'], $arraySaved)){
                                    $entradaEstoque = new EntradaEstoque();
                                    $entradaEstoque->obra_id                        = $obra->id;
                                    $entradaEstoque->usuario_id                     = \Auth::user()->id;
                                    $entradaEstoque->almoxarifado_id                = $itensConferidos['almoxarifado_id'];
                                    $entradaEstoque->funcionario_conferente_id      = $itensConferidos['funcionario_conferente_id'];
                                    $entradaEstoque->tipo_entrada_estoque_id        = $itensConferidos['tipo_entrada_estoque_id'];
                                    $entradaEstoque->data                           = dateToSave($itensConferidos['data']);
                                    $entradaEstoque->obs                            = $itensConferidos['obs'];
                                    $entradaEstoque->save();

                                    foreach ($materiaisConferidos as $matObraSeve){
                                        if ($matObraSeve['num_obra'] == $row['num_obra']) {
                                            $mat = TipoMaterial::where('codigo', $matObraSeve['codigo_material'])->first()->id;
                                            $estoque = new EntradaMaterialEstoque();
                                            $estoque->entrada_estoque_id = $entradaEstoque->id;
                                            $estoque->tipo_material_id = $mat;
                                            $estoque->qtde = $matObraSeve['quantidade'];
                                            $estoque->save();

                                            array_push($arraySaved, $row['num_obra']);
                                        }
                                    }
                                }
                            }
                        } else{
                            throw new \Exception('Atenção! Favor verificar se todos as obras listadas abaixo estão cadastradas.');
                        }
                    }

                    RegistroHistoricoObra::registerHistorico(Obra::find($entradaEstoque->obra_id),'Entrada de Estoque realizda');
                });

                \DB::commit();
                return response()->json(['success' => true, 'msg' => 'Entrada realizada com sucesso.']);

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

    public function conferirEntradaEstoque(Request $request)
    {
        $id = $request->input('id');
        $materiais = json_decode($request->input('materiais'));
        $entradaEstoque = EntradaEstoque::find($id);
        $arquivo = $request->file('arquivo');
        $almoxarifado_id = $request->input('almoxarifado_id');
        $materiaisAux = [];
        $metodo_entrada = $request->input('metodo_entrada');
        
        if(!$entradaEstoque) {
            $entradaEstoque = new EntradaEstoque();
        }

        $entradaEstoque->fill($request->all());
        $entradaEstoque->materiais = $materiais;

        // ============================================================//
        //=== VALIDANDO DATA RECEBIDA PARA SER >= QUE A DATA ATUAL ====//
        // ============================================================//

        // $data = $request->input('data');
        // $msg  = "";

        // if(strlen($data) == 10)
        // {
        //     if(strtotime($data) > strtotime(date('d/m/Y'))){
        //         $msg = "<ul style='margin-top:-12px;'><li>Data Recebimento é maior que data atual.</li></ul>";
        //     }
        // }

        $validade = null;
        if($metodo_entrada == 3) {
            $validade = validator($request->all(), $entradaEstoque->rulesVariasObras(), $entradaEstoque->msgRulesVariasObras);
        } else{
            $validade = validator($request->all(), $entradaEstoque->rules(), $entradaEstoque->msgRules);
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
                        $qtdeEstoque = 0;

                        //Verifica se nenhum dado da plainha é negativo
                        if ($row->qtdatd_num_obra == null || $row->qtdatd_num_obra <= 0 || $row->numobra == null) {
                            return response()->json(['success' => false, 'msg' => 'Valores negativos ou nulos na planinha, favor verificar.']);
                        }

                        if(!empty($row->codmat_mov) && !empty($row->dscmat) && !empty($row->numobra)){
                            $row->dscmat = str_replace('"', "'", $row->dscmat);
                            
                            $validarMaterial = TipoMaterial::where('codigo', $row->codmat_mov)->first();
                            $validarObra = Obra::where('numero_obra', $row->numobra)->first();

                            if (!$validarObra){
                                $obraExiste = 'n';
                            }

                            if(count($validarMaterial) == 0){
                                $existe = 'n';
                            } else {
                                //busca a quantidade do material no estoque.
                                $estoque = Estoque::where('tipo_material_id', $validarMaterial->id)
                                                  ->where('almoxarifado_id', $almoxarifado_id)
                                                  ->select(\DB::raw('SUM(qtde) as qtde'))
                                                  ->first();
                                
                                if(isset($estoque) && count($estoque) > 0) {
                                    $qtdeEstoque = $estoque->qtde;
                                }
                            }

                            array_push($materiaisAux, ['num_obra' => $row->numobra,
                                                         'codigo_material' => $row->codmat_mov,
                                                         'descricao' => $row->codmat_mov.' - '.$row->dscmat,
                                                         'descricao_original' => $row->dscmat,
                                                         'quantidade' => $row->qtdatd_num_obra,
                                                         'existe' => $existe,
                                                         'obraExiste' => $obraExiste,
                                                         'qtdeEstoque' => $qtdeEstoque]);
                        }else{
                            throw new \PHPExcel_Reader_Exception();
                        }
                    }

                    sort($materiaisAux);
                    $materiaisAux = json_encode($materiaisAux);
                    $entradaEstoque->materiais = json_decode($materiaisAux);
                } else {
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

                        //Verifica se nenhum dado da plainha é negativo
                        if ($row->rma == null || $row->rma <= 0) {
                            return response()->json(['success' => false, 'msg' => 'Valores negativos ou nulos na planinha, favor verificar.']);
                        }

                        if(!empty($row->codigo) && !empty($row->descricao)){
                            $row->descricao = str_replace('"', "'", $row->descricao);

                            $validarMaterial = TipoMaterial::where('codigo', $row->codigo)->first();

                            if(count($validarMaterial) == 0){
                                $existe = 'n';
                            } else {
                                //busca a quantidade do material no estoque.
                                $estoque = Estoque::where('tipo_material_id', $validarMaterial->id)
                                    ->where('almoxarifado_id', $almoxarifado_id)
                                    ->select(\DB::raw('SUM(qtde) as qtde'))
                                    ->first();

                                if(isset($estoque) && count($estoque) > 0) {
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
                    $entradaEstoque->materiais = json_decode($materiaisAux);

                } else {
                    return response()->json(['success' => false, 'msg' => 'Nenhum arquivo encontrado.']);
                }
            } catch (\PHPExcel_Reader_Exception $e) {
                return response()->json(['success' => false, 'msg' => 'Favor verificar o modelo do excel.']);
            }
        } elseif ($metodo_entrada == 1){
            //Entrada Manual
            if(!empty($materiais)){

                foreach ($materiais as $row) {
                    $validarMaterial = TipoMaterial::where('codigo', $row->codigo_material)->first();
                    //busca a quantidade do material no estoque.
                    $estoque = Estoque::where('tipo_material_id', $validarMaterial->id)
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
                $entradaEstoque->materiais = json_decode($materiaisAux);
            }else{
                return response()->json(['success' => false, 'msg' => 'Materiais não preenchido.']);
            }
        }

        if ($metodo_entrada == 3){
            return view('pages.entrada-estoque.conferir-varias-obras', compact('entradaEstoque'));
        } else{
            return view('pages.entrada-estoque.conferir', compact('entradaEstoque'));
        }
    }

    public function gerenciador(Request $request)
    {
        $this->authorize('CONSULTAR_ENTRADA_ESTOQUE');

        $users          = User::all()->toArray();
        $funcionario    = Funcionario::select('id',\DB::raw("CONCAT(nome, ' ' ,sobrenome) as nome"))->where('conferente', true)->get()->toArray();
        $obra           = Obra::all()->toArray();
        $tipoEntrada    = TipoEntrada::all()->toArray();
        $almoxarifados  = Almoxarifado::all()->toArray();
        $entradaEstoque = EntradaEstoque::filterEntradaEstoque($request->all())->orderByRaw('data DESC, created_at ASC')->paginate(10)->setPath('')->appends($request->query());

        return view('pages.entrada-estoque.gerenciador', compact('entradaEstoque', 'users', 'funcionario', 'obra', 'tipoEntrada', 'almoxarifados'));
    }

    public function exportarExcel(Request $request)
    {
        $this->authorize('EXPORTAR_COSULTA_ENTRADA_ESTOQUE');

        $dataAtual = date('Y-m-d_H:i');
        $data = EntradaEstoque::filterEntradaEstoque($request->all());

        $data = $data->select('obra.numero_obra as numero_obra','user.name as usuario','alm.nome as almoxarifado', \DB::RAW("CONCAT(func.nome, ' ' , func.sobrenome) as \"conferente\""),'entrada.nome as tipo_entrada', \DB::RAW("TO_CHAR(entrada_estoque.data,'DD/MM/YYYY') as \"data\""), 'entrada_estoque.obs as observacao')
                     ->join('obra as obra', 'obra.id','=','entrada_estoque.obra_id')
                     ->join('users as user', 'user.id','=','entrada_estoque.usuario_id')
                     ->join('almoxarifado as alm', 'alm.id','=','entrada_estoque.almoxarifado_id')
                     ->join('funcionarios as func', 'func.id','=','entrada_estoque.funcionario_conferente_id')
                     ->join('tipo_entrada as entrada', 'entrada.id','=','entrada_estoque.tipo_entrada_estoque_id')
                     ->orderBy('entrada_estoque.id')->get()->toArray();

        $excel = \Excel::create('Entrada_Estoque', function($excel) use ($data) {
            $excel->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $excel->sheet('Plan 1', function($sheet) use ($data)
            {
                $sheet->cell('A2:G2', function($cell) {
                    $cell->setFontWeight('bold');
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setBackground('#FFFFFF');
                });

                $sheet->cell('A:G', function($cell) {
                    $cell->setValignment('center');
                });

                $sheet->cell('S2', function($cell) {
                    $cell->setValignment('center');
                });

                $sheet->mergeCells('A1:G1');
                $sheet->setHeight(1, 53);
                $sheet->setBorder('A2:G2', 'thin');

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
                $sheet->setCellValue('E2', 'Tipo Entrada');
                $sheet->setCellValue('F2', 'Data');
                $sheet->setCellValue('G2', 'Observação');
                $sheet->setHeight(2, 40.5);
                $sheet->getStyle('G1:G9999')->getAlignment()->setWrapText(true);
                $sheet->setAutoSize(array(
                    'A', 'B', 'C', 'D', 'E', 'F'
                ));
                $sheet->setWidth(array(
                    'G'     =>  75
                ));

                for ($iRow = 3; $iRow < count($data) + 3; $iRow++){
                    $sheet->setCellValue('A' . $iRow, $data[$iRow-3]['numero_obra']);
                    $sheet->setCellValue('B' . $iRow, $data[$iRow-3]['usuario']);
                    $sheet->setCellValue('C' . $iRow, $data[$iRow-3]['almoxarifado']);
                    $sheet->setCellValue('D' . $iRow, $data[$iRow-3]['conferente']);
                    $sheet->setCellValue('E' . $iRow, $data[$iRow-3]['tipo_entrada']);
                    $sheet->setCellValue('F' . $iRow, $data[$iRow-3]['data']);
                    $sheet->setCellValue('G' . $iRow, $data[$iRow-3]['observacao']);
                }

            });
        })->string('xlsx');

        $response =  array(
            'success' => true,
            'name' => "Entrada_Estoque_".$dataAtual.".xlsx",
            'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,".base64_encode($excel)
        );

        return response()->json($response);
    }

    public function exportarPdf(Request $request)
    {
        $this->authorize('EXPORTAR_COSULTA_ENTRADA_ESTOQUE');

        $titulo = 'Entrada Estoque';
        $name   = "Entrada_Estoque_".date('Y-m-d_H-i');
        $route  = 'pages.entrada-estoque.export-pdf';

        $filter = $request->input('filtro_input');
        $result = EntradaEstoque::filterEntradaEstoque($request->all())->get();

        if(count($result) == 0){
            notify()->flash('Não foi possível Gerar o PDF.', 'danger');
            return back()->withInput();
        }else{
            return exportPdf($titulo, $result, $name,$route);
        }
    }

}