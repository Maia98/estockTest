<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use App\Model\Obra;
use App\Model\Almoxarifado;
use App\Model\TipoMaterial;
use App\Model\Estoque;
use App\Model\TransferenciaEstoque;
use App\Model\TransferenciaMaterialEstoque;
use App\Model\RegistroHistoricoObra;

class TransferenciaEstoqueController extends Controller
{
    public function index()
    {
        return view('pages.transferencia-estoque.index');
    }

    public function gerenciador(Request $request){

        $this->authorize('CONSULTAR_TRANSFERENCIA_ESTOQUE');

        $page           = $request->input('page', 1);
        $almoxarifados  = Almoxarifado::select('id','nome')->get()->toArray();
        $obras          = Obra::select('id','numero_obra')->get()->toArray();
        $usuarios       = User::select('id','name')->get()->toArray();
        $result         = TransferenciaEstoque::filterTransferenciaEstoque($request->all())->get();
        $result         = paginate($page, $request, 10, $result->toArray());
        $result         = $result->setPath('')->appends($request->query());

        return view('pages.transferencia-estoque.gerenciador', compact('result','almoxarifados','usuarios','obras'));
    }

    public function details($id){

        $this->authorize('CONSULTAR_LISTA_TRANSFERENCIA_ESTOQUE');
        $transferencia = TransferenciaEstoque::find($id);
        $materiaisTransferencia = TransferenciaMaterialEstoque::where('transferencia_material_estoque.transferencia_estoque_id', $id)
                                    ->get();

        return view('pages.transferencia-estoque.details', compact('transferencia', 'materiaisTransferencia'));
    }

    public function create()
    {
        $this->authorize('CADASTRAR_TRANSFERENCIA_ESTOQUE');
        $almoxarifados =  arrayToSelect(Almoxarifado::all()->toArray(), 'id', 'nome');
        return view('pages.transferencia-estoque.cadastro', compact('almoxarifados'));
    }

    public function obrasOrigem(Request $request)
    {
        $almoxarifado = $request->input('almoxarifado');

        if($almoxarifado)
        {
            $obras = Obra::join('estoque', 'obra.id', '=', 'estoque.obra_id')
                        ->select('obra.*')
                        ->where('estoque.almoxarifado_id', $almoxarifado)
                        ->distinct()
                        ->orderBy('obra.numero_obra')
                        ->get();

            return response()->json($obras);
        }else{
            return response()->json(null);
        }
    }

    public function obrasDestino(Request $request)
    {
        $obraOrigem = $request->input('obraOrigem');

        $obras = Obra::where('id', '>', 0)->orderBy('numero_obra')->distinct();
        
        if($obraOrigem)
        {
            $obras = $obras->where('id', '<>', $obraOrigem);
        }

        $obras = $obras->get();

        return response()->json($obras);
    }

    public function selecionarEstoque(Request $request, TransferenciaEstoque $transferencia)
    {
        $this->authorize('CADASTRAR_TRANSFERENCIA_ESTOQUE');

        $codigoAlmoxarifadoOrigem = $request->input('almoxarifado_origem_id');
        $codigoObraOrigem = $request->input('obra_origem_id');
        $codigoAlmoxarifadoDestino = $request->input('almoxarifado_destino_id');
        $codigoObraDestino = $request->input('obra_destino_id');
        $dataTransferencia = $request->input('data');
        $validade = validator($request->all(), $transferencia->rules(), $transferencia->msgRules);
        
        if($validade->fails())
        {
            notify()->flash(arrayToValidator($validade->getMessageBag()), 'warning');
            return redirect()->back()->withInput();
        }

        $almoxarifadoOrigem = Almoxarifado::find($codigoAlmoxarifadoOrigem);
        $obraOrigem = Obra::find($codigoObraOrigem);
        $almoxarifadoDestino = Almoxarifado::find($codigoAlmoxarifadoDestino);
        $obraDestino = Obra::find($codigoObraDestino);
        //dd($almoxarifadoOrigem, $obraOrigem, $almoxarifadoDestino, $obraDestino);
        return view('pages.transferencia-estoque.materiais', compact('almoxarifadoOrigem', 'obraOrigem', 'almoxarifadoDestino', 'obraDestino', 'dataTransferencia'));
    }

    public function pesquisarMaterial(Request $request)
    {
        $material = $request->input('q');
        $almoxarifado = $request->input('alx');
        $obraOrigem = $request->input('obr_o');
        $obraDestino = $request->input('obr_d');
        $page = ($request->input('page')) ? $request->input('page') : 1;

        if(!is_numeric($almoxarifado) ||  $almoxarifado < 1)
        {
            return response()->json('Almoxarifado inválido. Por favor, inicie o processo de transferência novamente.', 500);
        }

        $materiais = Estoque::join('tipo_material', 'estoque.tipo_material_id', '=', 'tipo_material.id')
                            ->join('tipo_unidade_medida', 'tipo_unidade_medida.id', '=', 'tipo_material.tipo_unidade_medida_material_id')
                            ->select(DB::raw('estoque.tipo_material_id as id, tipo_material.codigo, tipo_material.descricao as text, SUM(estoque.qtde) as qtde, tipo_unidade_medida.codigo as unid_medida'))
                            ->where('estoque.almoxarifado_id', $almoxarifado)
                            ->where('estoque.obra_id', '<>' ,$obraDestino)
                            ->groupBy('estoque.tipo_material_id', "tipo_material.codigo", 'tipo_material.descricao', 'tipo_unidade_medida.codigo')
                            ->havingRaw('SUM(estoque.qtde) > 0');

        if(is_numeric($material))
        {
            $materiais = $materiais->where(function($where) use ($material) {
                $where->where('tipo_material.descricao', 'ilike', "%" .$material. "%");
                $where->orWhere(DB::raw('CAST(tipo_material.codigo AS text)'), 'like', "%" .$material. "%");
            });
        }else{
            $materiais = $materiais->where('tipo_material.descricao', 'ilike', "%" .$material. "%");
        }

        if($obraOrigem > 0)
        {
            $materiais = $materiais->where('estoque.obra_id', $obraOrigem);
        }

        //\Debugbar::info($materiais->toSql());
        $materiais = $materiais->paginate(10);

        return response()->json($materiais);
    }

    public function selecionarMaterial(Request $request)
    {
        $almoxarifado = $request->input('alx');
        $obraOrigem = $request->input('obr_o');
        $obraDestino = $request->input('obr_d');
        $material = $request->input('mat');
        $qtde = $request->input('qtd');


        $estoqueAtual = Estoque::where('almoxarifado_id', $almoxarifado)
                            ->where('tipo_material_id', $material)
                            ->where('obra_id', '<>', $obraDestino);

        if($obraOrigem > 0)
        {
            $estoqueAtual = $estoqueAtual->where('obra_id', $obraOrigem);
        }

        $estoqueAtual = $estoqueAtual->sum('qtde');

        if($estoqueAtual < $qtde)
        {
            return response()->json(['success' => false, 'msg' => 'Estoque insuficiente']);
        }


        $materiais = Estoque::join('tipo_material', 'estoque.tipo_material_id', '=', 'tipo_material.id')
                            ->join('obra', 'estoque.obra_id', '=', 'obra.id')
                            ->join('tipo_unidade_medida', 'tipo_material.tipo_unidade_medida_material_id', '=', 'tipo_unidade_medida.id')
                            ->where('almoxarifado_id', $almoxarifado)
                            ->where('tipo_material_id', $material)
                            ->where('obra_id', '<>',  $obraDestino)
                            ->where('qtde', '>', 0)
                            ->select('obra.id as obra_id', 'obra.numero_obra', 'tipo_material.id as material_id', 'tipo_material.descricao as material_descricao',
                                'qtde', 'tipo_unidade_medida.codigo as unidade_medida')
                            ->orderBy('qtde');

        if($obraOrigem > 0)
        {
            $materiais = $materiais->where('obra_id', $obraOrigem);
        }

        $materiais = $materiais->get();

        $qtdeSolicitada = $qtde;
        $materiaisResult = [];
        foreach($materiais as $row)
        {
            $qtdeRow = 0;
            
            if($qtdeSolicitada > $row->qtde)
            {
                $qtdeRow = $row->qtde;
                $qtdeSolicitada -= $row->qtde;
            }else{
                $qtdeRow = $qtdeSolicitada;
                $qtdeSolicitada = 0;
            }

            $materiaisResult[] = [  'obra_id' => $row->obra_id, 
                                    'numero_obra' => $row->numero_obra,
                                    'material_id' => $row->material_id,
                                    'material_descricao' => $row->material_descricao,
                                    'qtde' => $qtdeRow,
                                    'unidade_medida' => $row->unidade_medida ];
            
            if($qtdeSolicitada <= 0)
            {
                break;
            }
        }

        return response()->json(['success' => true, 'itens' => $materiaisResult]);
    }

    public function store(Request $request)
    {
        $this->authorize('CADASTRAR_TRANSFERENCIA_ESTOQUE');
        try {
            
            \DB::transaction(function () use ($request) {

                $obrasLog = [];
                $transferenciaEstoque = new TransferenciaEstoque();
                $transferenciaEstoque->fill($request->all());
                $transferenciaEstoque->data = dateToSave($transferenciaEstoque->data);
                $transferenciaEstoque->usuario_id = \Auth::user()->id;
                $transferenciaEstoque->save();

                $materiaisTransferencia = $request->input('materiais');

                if(!$materiaisTransferencia)
                {
                    throw new \Exception('Erro! Nenhum material encontrado.');
                }
                $materiaisTransferencia = json_decode($materiaisTransferencia);

                foreach ($materiaisTransferencia as $material) {

                    $transferencia = new TransferenciaMaterialEstoque();
                    $transferencia->transferencia_estoque_id = $transferenciaEstoque->id;
                    $transferencia->tipo_material_id = $material->material_id;
                    $transferencia->obra_origem_id = $material->obra_id;
                    $transferencia->qtde = $material->qtde;
                    $transferencia->save();
                    $obrasLog[] = $material->obra_id;
                }

                $obrasLog = array_unique($obrasLog);

                RegistroHistoricoObra::registerHistorico(Obra::find($transferenciaEstoque->obra_destino_id),'Transferência de material realizada para a obra: ' .$transferenciaEstoque->obra_destino_id. ' das obras: ' .implode(',', $obrasLog). '.');

                foreach($obrasLog as $rowLog)
                {
                    RegistroHistoricoObra::registerHistorico(Obra::find($rowLog),'Transferência de material realizada da obra: ' .$rowLog. ' para a obra: ' .$transferenciaEstoque->obra_destino_id. '.');
                }
            }); 

            return response()->json(['success' => true, 'msg' => 'Transferência realizada com sucesso']);
        } catch (\Exception $e) {
            // \Debugbar::info($e);
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function exportarExcel(Request $request)
    {
        $this->authorize('EXPORTAR_TRANSFERENCIA_ESTOQUE');

        $dataAtual = date('Y-m-d_H:i');
        $data = TransferenciaEstoque::filterTransferenciaEstoque($request->all());

        $data = $data->select('obra.numero_obra as obra_destino', 'alm.nome as almoxarifado_destino', 'user.name as usuario', 'transferencia_estoque.data as data' )
                     ->join('users as user', 'user.id','=','transferencia_estoque.usuario_id')
                     ->join('almoxarifado as alm', 'alm.id','=','transferencia_estoque.almoxarifado_destino_id')
                     ->join('obra', 'obra.id', '=', 'transferencia_estoque.obra_destino_id')
                     ->get()->toArray();


        $excel = \Excel::create('Transferencia_Estoque', function($excel) use ($data) {
            $excel->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $excel->sheet('Plan 1', function($sheet) use ($data)
            {

                $sheet->cell('A2:D2', function($cell) {
                    $cell->setFontWeight('bold');
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setBackground('#FFFFFF');
                });

                $sheet->cell('A:D', function($cell) {
                    $cell->setValignment('center');
                });

                $sheet->mergeCells('A1:D1');
                $sheet->setHeight(1, 53);
                $sheet->setBorder('A2:D2', 'thin');

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


                $sheet->setCellValue('A2', 'Obra Destino');
                $sheet->setCellValue('B2', 'Almoxarifado Destino');
                $sheet->setCellValue('C2', 'Usuário');
                $sheet->setCellValue('D2', 'Data');
                $sheet->setHeight(2, 40.5);


                for ($iRow = 3; $iRow < count($data) + 3; $iRow++){
                    $sheet->setCellValue('A' . $iRow, $data[$iRow-3]['obra_destino']);
                    $sheet->setCellValue('B' . $iRow, $data[$iRow-3]['almoxarifado_destino']);
                    $sheet->setCellValue('C' . $iRow, $data[$iRow-3]['usuario']);
                    $sheet->setCellValue('D' . $iRow, $data[$iRow-3]['data']);
                }

            });
        })->string('xlsx');

        $response =  array(
            'success' => true,
            'name' => "Transferencia_Estoque".$dataAtual.".xlsx",
            'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,".base64_encode($excel)
        );

        return response()->json($response);
    }

    public function exportarPdf(Request $request)
    {
        $this->authorize('EXPORTAR_TRANSFERENCIA_ESTOQUE');

        $titulo = 'Transferência Estoque';
        $name   = "Transferencia_Estoque_".date('Y-m-d_H-i');
        $route  = 'pages.transferencia-estoque.export-pdf';

        $filter = $request->input('filtro_input');
        $result = TransferenciaEstoque::filterTransferenciaEstoque($request->all())->get();

        if(count($result) == 0){
            notify()->flash('Não foi possível Gerar o PDF.', 'danger');
            return back()->withInput();
        }else{
            return exportPdf($titulo, $result, $name,$route);
        }

    }

    public function exportarDetalhesExcel($id)
    {
        $this->authorize('EXPORTAR_LISTA_TRANSFERENCIA_ESTOQUE');

        $dataAtual = date('Y-m-d_H-i');

        $data = TransferenciaEstoque::select('alm.nome as almoxarifado_origem', 'almdestino.nome as almoxarifado_destino','obra.numero_obra as numero_obra_origem', 'obra_destino.numero_obra as numero_obra_destino','mat.codigo as codigo', 'mat.descricao as descricao', 'uni.codigo as codigo_mat', 'trans.qtde_obra_origem as qtde_origem', 'trans.qtde_obra_destino as qtde_destino', 'trans.qtde as qtde_transf')
                                      ->join('transferencia_material_estoque as trans', 'trans.transferencia_estoque_id','=','transferencia_estoque.id' )
                                      ->join('tipo_material as mat', 'mat.id', '=', 'trans.tipo_material_id')
                                      ->join('almoxarifado as alm', 'alm.id','=', 'transferencia_estoque.almoxarifado_origem_id')
                                      ->join('almoxarifado as almdestino', 'almdestino.id','=', 'transferencia_estoque.almoxarifado_destino_id')
                                      ->join('obra', 'obra.id', '=', 'trans.obra_origem_id')
                                      ->join('obra as obra_destino', 'obra_destino.id', '=', 'transferencia_estoque.obra_destino_id')
                                      ->join('tipo_unidade_medida as uni', 'uni.id', '=', 'mat.tipo_unidade_medida_material_id')
                                     ->where('transferencia_estoque.id', $id)->get()->toArray();

        return \Excel::create('Detalhe_Transferência_'.$dataAtual, function($excel) use ($data) {

            $excel->sheet('Plan 1', function($sheet) use ($data)
            {
                $sheet->cell('A2:L2', function($cell) {
                    $cell->setFontWeight('bold');
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setBackground('#FFFFFF');
                });
                $sheet->mergeCells('A1:L1');
                $sheet->setHeight(1, 53);
                $sheet->setBorder('A2:L2', 'thin');

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
                $sheet->setCellValue('A2', 'Almoxarifado Origem');
                $sheet->setCellValue('B2', 'Almoxarifado Destino');
                $sheet->setCellValue('C2', 'Obra Origem');
                $sheet->setCellValue('D2', 'Obra Destino');
                $sheet->setCellValue('E2', 'Código');
                $sheet->setCellValue('F2', 'Material');
                $sheet->setCellValue('G2', 'Unidade');
                $sheet->setCellValue('H2', 'qtde Obra Origem');
                $sheet->setCellValue('I2', 'qtde Obra Destino');
                $sheet->setCellValue('J2', 'qtde Transferida');
                $sheet->setCellValue('K2', 'Saldo Obra Origem');
                $sheet->setCellValue('L2', 'Saldo Obra Destino');
                $sheet->setHeight(2, 40.5);

                for ($iRow = 3; $iRow < count($data) + 3; $iRow++){
                    $sheet->setCellValue('A' . $iRow, $data[$iRow-3]['almoxarifado_origem']);
                    $sheet->setCellValue('B' . $iRow, $data[$iRow-3]['almoxarifado_destino']);
                    $sheet->setCellValue('C' . $iRow, $data[$iRow-3]['numero_obra_origem']);
                    $sheet->setCellValue('D' . $iRow, $data[$iRow-3]['numero_obra_destino']);
                    $sheet->setCellValue('E' . $iRow, $data[$iRow-3]['codigo']);
                    $sheet->setCellValue('F' . $iRow, $data[$iRow-3]['descricao']);
                    $sheet->setCellValue('G' . $iRow, $data[$iRow-3]['codigo_mat']);
                    $sheet->setCellValue('H' . $iRow, $data[$iRow-3]['qtde_origem']);
                    $sheet->setCellValue('I' . $iRow, $data[$iRow-3]['qtde_destino']);
                    $sheet->setCellValue('J' . $iRow, $data[$iRow-3]['qtde_transf']);
                    $sheet->setCellValue('K' . $iRow, $data[$iRow-3]['qtde_origem'] - $data[$iRow-3]['qtde_transf']);
                    $sheet->setCellValue('L' . $iRow, $data[$iRow-3]['qtde_destino'] + $data[$iRow-3]['qtde_transf']);

                }
            });
        })->download('xlsx');
    }

    public function exportarDetalhesPdf(Request $request, $id)
    {
        $this->authorize('EXPORTAR_LISTA_TRANSFERENCIA_ESTOQUE');

        $transferencia = TransferenciaEstoque::Join('transferencia_material_estoque as trans', 'trans.transferencia_estoque_id','=','transferencia_estoque.id')
        ->join('obra as obra_origem', 'obra_origem.id', '=', 'trans.obra_origem_id')
        ->join('obra as obra_destino', 'obra_destino.id', '=', 'transferencia_estoque.obra_destino_id')
        ->select('transferencia_estoque.almoxarifado_origem_id', 'transferencia_estoque.almoxarifado_destino_id', 'obra_origem.numero_obra as numero_obra_origem', 'obra_destino.numero_obra as numero_obra_destino', 'transferencia_estoque.data')
        ->where('transferencia_estoque.id', $id)
        ->first();
        
        $titulo = "Detalhes Tranferência - Data Transferência: ".date("d/m/Y", strtotime($transferencia->data));
        $result =TransferenciaEstoque::select('alm.nome as almoxarifado_origem', 'obra.numero_obra as numero_obra', 'mat.codigo as codigo', 'mat.descricao as descricao', 'uni.codigo as codigo_mat', 'trans.qtde_obra_origem as qtde_origem', 'trans.qtde_obra_destino as qtde_destino', 'trans.qtde as qtde_transf')
                                        ->join('transferencia_material_estoque as trans', 'trans.transferencia_estoque_id','=','transferencia_estoque.id' )
                                        ->join('tipo_material as mat', 'mat.id', '=', 'trans.tipo_material_id')
                                        ->join('almoxarifado as alm', 'alm.id','=', 'transferencia_estoque.almoxarifado_origem_id')
                                        ->join('obra', 'obra.id', '=', 'trans.obra_origem_id')
                                        ->join('tipo_unidade_medida as uni', 'uni.id', '=', 'mat.tipo_unidade_medida_material_id')
                                        ->where('transferencia_estoque.id', $id)->get();
                                        
        $name = "Tranferência_".date('Y-m-d_H-i');
        $route = 'pages.transferencia-estoque.export-pdf-detalhe';

        if(count($result) == 0){
            notify()->flash('Não foi possível Gerar o PDF.', 'danger');
            return back()->withInput();
        }else{
            return exportPdf($titulo, $result, $name, $route, "landscape", $transferencia);
        }
    }
}