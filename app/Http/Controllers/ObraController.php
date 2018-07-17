<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Obra;
use App\Model\TipoSetorObra;
use App\Model\Cidade;
use App\Model\Empresa;
use App\Model\Regional;
use App\Model\TipoPrioridade;
use App\Model\TipoObra;
use App\Model\StatusObra;
use App\Model\Funcionario;
use App\Model\TipoApoio;
use App\Model\ApoioExecucaoHasObra;
use App\Model\FuncionarioEncarregadoHasObra;
use App\Model\MaterialOrcado;
use App\Model\RegistroHistoricoObra;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;


class ObraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('CONSULTAR_OBRA');

        $page       = $request->input('page', 1);
        $statusObra = StatusObra::all()->toArray();
        $regionais  = Regional::all()->toArray();
        $cidades    = Cidade::select('id','nome');
        $setores    = TipoSetorObra::all()->toArray();

        if($request->input('filter_regional')){
            $cidades = $cidades->where('regional_id', $request->input('filter_regional'));
        }

        $cidades = $cidades->get()->toArray();
        $encarregados = Funcionario::select('id', \DB::raw("nome ||' '|| sobrenome as nome"))->where('encarregado', true)->get()->toArray();

        if($request->input('filtro_saldo') > 0){
            $result = Obra::getSaldoPositivoAndNegativo($request->all(), $request->input('filtro_saldo'))->get();
            $result = paginate($page, $request, 10, $result->toArray());
        }else{
            $result = Obra::filterObra($request->all())->groupBy('obra.id')->orderBy('data_recebimento','desc')->paginate(10);
        }

        $result = $result->setPath('')->appends($request->query());

        return view('pages.obra.index', compact('statusObra', 'cidades', 'regionais', 'encarregados', 'result', 'setores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('CADASTRAR_OBRA');
        $setorObra = TipoSetorObra::all()->toArray();
        $cidades = Cidade::all()->toArray();
        $prioridadeObra = TipoPrioridade::all()->toArray();
        $tipoObra = TipoObra::all()->toArray();
        $statusObra = StatusObra::orderBy('id')->get()->toArray();
        $apoios = TipoApoio::all()->toArray();
        
        $supervisores = Funcionario::select('id', \DB::raw("nome || ' ' || sobrenome as nome"))
                                    ->where('supervisor', true)
                                    ->get()
                                    ->toArray();
        
        $fiscais = Funcionario::select('id', \DB::raw("nome || ' ' || sobrenome as nome"))
                               ->where('fiscal', true)
                               ->get()
                               ->toArray();
        
        $encarregados = Funcionario::select('id', \DB::raw("nome || ' ' || sobrenome as nome"))
                                    ->where('encarregado', true)
                                    ->get()
                                    ->toArray();
        
        return view('pages.obra.form', compact('setorObra', 'cidades', 'prioridadeObra', 'tipoObra', 'statusObra', 'supervisores','fiscais', 'encarregados', 'apoios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('CADASTRAR_OBRA');
        $id               = $request->input('id');
        $obra             = Obra::find($id);
        $apoios           = $request->apoio;
        $arrayApoio       = explode(",", $apoios);
        $encarregados     = $request->encarregados;
        $arrayEcarregados = explode(",", $encarregados);
        $save             = null;
        $errors           = 0;
        $erroPlanilha     = '';
        $arquivo = $request->file('arquivo');
        $mensagemHistorico = "Alteração de informações da obra";
        
        if(!$obra){
            $obra = new Obra();
            $mensagemHistorico = "Obra Cadastrada";
        }

        $obra->fill($request->all());

        $obra->data_abertura = dateToSave($obra->data_abertura,true);
        $obra->data_recebimento = dateToSave($obra->data_recebimento,true);
        $obra->data_previsao_retirada_material = dateToSave($obra->data_previsao_retirada_material,true);
        $obra->prazo_execucao_inicio = dateToSave($obra->prazo_execucao_inicio,true);
        $obra->prazo_execucao_fim = dateToSave($obra->prazo_execucao_fim,true);


        $validade = validator($request->all(), $obra->rules(), $obra->msgRules);

        if($validade->fails())
        {
            return response()->json(['success' => false, 'msg' => arrayToValidator($validade->getMessageBag())]);
        } 

        if($obra->valor_orcado == '0.00'){
            
            $obra->valor_orcado = null;
        }else{
            
            $obra->valor_orcado = floatval(str_replace(',', '.', str_replace('.', '', $obra->valor_orcado)));
        }

        // função que coloca valores nulos em fiscal/supervisor caso venha selecionado a opção 0 
        $obra->validaSupervisorAndFiscal();
        $save = $obra->save();

        if($save){
            // salvando no historico da obra o cadastro ou atualização da mesma
            RegistroHistoricoObra::registerHistorico($obra,$mensagemHistorico);
        }

        $apoio = ApoioExecucaoHasObra::where('obra_id', $obra->id)->delete();
        
        if(isset($apoios))
        {
            
            for($i = 0; $i < count($arrayApoio); $i++ ){
                $apoio = new ApoioExecucaoHasObra();
                $apoio->apoio_execucao_obra_id  =  $arrayApoio[$i];
                $apoio->obra_id                 =  $obra->id;
                $save = $apoio->save();

                if(!$save){
                    $errors++;
                }
            }
        }

        $encarregado = FuncionarioEncarregadoHasObra::where('obra_id', $obra->id)->delete();
        if(isset($encarregados))
        {

            for($i = 0; $i < count($arrayEcarregados); $i++ ){
                $encarregado = new FuncionarioEncarregadoHasObra();
                $encarregado->funcionario_id    =  $arrayEcarregados[$i];
                $encarregado->obra_id           =  $obra->id;
                $save = $encarregado->save();

                if(!$save){
                    $errors++;
                }
            }
            
        }

        try {

            if($arquivo){
                $dados = \Excel::load($arquivo, function ($reader) {
                })->toObject();
                
                foreach ($dados as $row) {
                    $existe = '';
                    $qtdeEstoque = 0;

                    if($row->qtd_orc == null){
                        $row->qtd_orc = 0 ;
                    }

                    if(!empty($row->codigo) && !empty($row->descricao)){
                        //dd($obra->id);
                        $materialOrcado = new MaterialOrcado();
                        $materialOrcado->obra_id = $obra->id;
                        $materialOrcado->cod_mat = $row->codigo;
                        $materialOrcado->descricao_mat = $row->descricao;
                        $materialOrcado->qtd_orc = $row->qtd_orc;
                        $materialOrcado->save();
                        
                    }else{
                        $erroPlanilha = 'Falha ao importar planilha favor verificar. aa';
                    }
                }
                
            }
        } catch (\PHPExcel_Reader_Exception $e) {
            $erroPlanilha = 'Falha ao importar planilha favor verificar. bb';
        }

        if($errors <= 0)
        {
            return response()->json(['success' => true, 'msg' => 'Obra cadastrado com sucesso. '. $erroPlanilha]);
        }else{
            return response()->json(['success' => false, 'msg' => 'Erro ao cadastrar Obra. '. $erroPlanilha]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Obra $obra)
    {
        $this->authorize('CADASTRAR_OBRA');
        $setorObra = TipoSetorObra::all()->toArray();
        $cidades = Cidade::all()->toArray();
        $prioridadeObra = TipoPrioridade::all()->toArray();
        $tipoObra = TipoObra::all()->toArray();
        $statusObra = StatusObra::orderBy('id')->get()->toArray();
        $apoios = TipoApoio::all()->toArray();
        
        $supervisores = Funcionario::select('id', \DB::raw("nome || ' ' || sobrenome as nome"))
                                    ->where('supervisor', true)
                                    ->get()
                                    ->toArray();
        
        $fiscais = Funcionario::select('id', \DB::raw("nome || ' ' || sobrenome as nome"))
                               ->where('fiscal', true)
                               ->get()
                               ->toArray();
        
        $encarregados = Funcionario::select('id', \DB::raw("nome || ' ' || sobrenome as nome"))
                                    ->where('encarregado', true)
                                    ->get()
                                    ->toArray();

        $materialOrcado = MaterialOrcado::where('obra_id', $obra->id)->select('obra_id')->get();

        $obra->formatInputs();
        
        return view('pages.obra.form', compact('setorObra', 'cidades', 'prioridadeObra', 'tipoObra', 'statusObra', 'supervisores','fiscais', 'encarregados', 'apoios', 'obra', 'materialOrcado'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Obra $obra)
    {
        return view('pages.obra.delete', compact('obra'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
/*    public function destroy(Request $request)
    {
        $id = $request->input('id');

        try {
            $apoio = ApoioExecucaoHasObra::where('obra_id', $id)->delete();
            $encarregado = FuncionarioEncarregadoHasObra::where('obra_id', $id)->delete();
            $detete = \DB::table('obra')->where('id', $id)->delete();

            if($detete)
            {

                notify()->flash('Obra excluido com sucesso.', 'success');

            }else{

                notify()->flash('Erro ao excluir Obra.', 'danger');

            }
        } catch (\Exception $exc) {
            if( $exc->getCode() == 23503) {

                notify()->flash('Não é permitido excluir Obra em uso.', 'danger');   

            }else{
                
                notify()->flash('Erro ao excluir Obra.', 'danger');        
            }
        } finally {
            return redirect()->action('ObraController@index');  
        }  
    }*/
    
    public function exportarExcel(Request $request)
    {

        $this->authorize('EXPORTAR_CONSULTA_OBRA');
        $data = Obra::filterObra($request->all(), true)->get();

        $excel = \Excel::create('export_obra', function($excel) use ($data) {
            $excel->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $excel->sheet('Plan 1', function($sheet) use ($data)
            {
                $sheet->cell('A2:P2', function($cell) {
                    $cell->setFontWeight('bold');
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setBackground('#FFFFFF');
                });

                $sheet->cell('A:P', function($cell) {
                    $cell->setValignment('center');
                });

                $sheet->mergeCells('A1:P1');
                $sheet->setHeight(1, 53);
                $sheet->setBorder('A2:P2', 'thin');
                
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
                $sheet->setCellValue('B2', 'Pes');
                $sheet->setCellValue('C2', 'Book Fotográfico');
                $sheet->setCellValue('D2', 'Medidor Instalado');
                $sheet->setCellValue('E2', 'Telefonia');
                $sheet->setCellValue('F2', 'Data Recebimento');
                $sheet->setCellValue('G2', 'Início');
                $sheet->setCellValue('H2', 'Término');
                $sheet->setCellValue('I2', 'Previsão Ret. Material');
                $sheet->setCellValue('J2', 'Prioridade');
                $sheet->setCellValue('K2', 'Apoio');
                $sheet->setCellValue('L2', 'Cidade');
                $sheet->setCellValue('M2', 'Encarregados');
                $sheet->setCellValue('N2', 'Status');
                $sheet->setCellValue('O2', 'Observação');
                $sheet->setCellValue('P2', 'Dados do Trafo.');
                $sheet->setHeight(2, 40.5);
                $sheet->getStyle('O2:O9999')->getAlignment()->setWrapText(true);
                $sheet->setAutoSize(array(
                    'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'L', 'N', 'P'
                ));

                $sheet->setWidth(array(
                    'K' => 75,
                    'M' => 75,
                    'O' => 75,
                ));

                for ($iRow = 3; $iRow < count($data) + 3; $iRow++){
                    $sheet->setCellValue('A' . $iRow, $data[$iRow-3]->numero_obra);
                    $sheet->setCellValue('F' . $iRow, dateToView($data[$iRow-3]->data_recebimento));
                    $sheet->setCellValue('G' . $iRow, dateToView($data[$iRow-3]->inicio, true));
                    $sheet->setCellValue('H' . $iRow, dateToView($data[$iRow-3]->termino, true));
                    $sheet->setCellValue('I' . $iRow, dateToView($data[$iRow-3]->ret_material));
                    $sheet->setCellValue('J' . $iRow, $data[$iRow-3]->prioridade);
                    $sheet->setCellValue('K' . $iRow, $data[$iRow-3]->apoios);
                    $sheet->setCellValue('L' . $iRow, $data[$iRow-3]->cidade);
                    $sheet->setCellValue('M' . $iRow, $data[$iRow-3]->encarregados);
                    $sheet->setCellValue('N' . $iRow, $data[$iRow-3]->status_obra);
                    $sheet->setCellValue('O' . $iRow, $data[$iRow-3]->observacao);
                }
            });
        })->string('xlsx');

        $response =  array(
            'success' => true,
            'name' => "Obra_Sintética_".date('Y-m-d_H:i').".xlsx",
            'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,".base64_encode($excel)
        );

        return response()->json($response);

    }

    public function exportarPdf(Request $request)
    {
        $this->authorize('EXPORTAR_CONSULTA_OBRA');
        $titulo = 'Gerenciar Obra(s)';
        $result = Obra::filterObra($request->all())->get();
        $name   = "Gerenciar_Obra_".date('Y-m-d_H-i');
        $route  = 'pages.obra.export-pdf';

        if(count($result) == 0){
            notify()->flash('Não foi possível Gerar o PDF.', 'danger');
            return back()->withInput();
        }else{
            return exportPdf($titulo, $result, $name,$route);
        }
        
    }

    public function showDetails(Obra $obra) {

        $this->authorize('CONSULTAR_DETALHES_OBRA');

        $obra->formatInputs();

        $encarregado = FuncionarioEncarregadoHasObra::join('funcionarios', 'funcionarios.id', '=', 'funcionario_encarregado_has_obra.funcionario_id')
                                                    ->where('obra_id', $obra->id)
                                                    ->get();

        $apoio =  ApoioExecucaoHasObra::join('tipo_apoio','tipo_apoio.id', '=', 'apoio_execucao_obra_has_obra.apoio_execucao_obra_id')
                                        ->where('obra_id', $obra->id)
                                        ->get();

        return view('pages.obra.details', compact('obra', 'encarregado', 'apoio'));
    }

    public function exportarListaoExcel(Request $request){
        
        $this->authorize('EXPORTAR_CONSULTA_OBRA');

        $ex = \PHPExcel_IOFactory::createReader('Excel2007');
        $ex = $ex->load(base_path('storage/app/public/modelos/modelo-listao-dinamico.xltm'));
        $activeSheet = $ex->setActiveSheetIndex(0);
        $numerosDeObras = '';
        $numerosDeObrasArray = [];

        $data = MaterialOrcado::filterMaterialOrcado($request->all())->get();
        if(count($data) > 0){
            for ($iRow = 3; $iRow < count($data) + 3; $iRow++){
                $activeSheet->setCellValue('A' . $iRow, $data[$iRow-3]->numero_obra);
                $activeSheet->setCellValue('B' . $iRow, $data[$iRow-3]->cod_mat);
                $activeSheet->setCellValue('C' . $iRow, $data[$iRow-3]->descricao_mat);
                $activeSheet->setCellValue('D' . $iRow, $data[$iRow-3]->qtd_orc);

                array_push($numerosDeObrasArray, $data[$iRow-3]->numero_obra);
            }
            $numerosDeObrasArray = array_values(array_unique($numerosDeObrasArray));

            for ($xRow = 0; count($numerosDeObrasArray) > $xRow; $xRow++) {

                if ($xRow == sizeof($numerosDeObrasArray) - 1) {
                    $numerosDeObras .= $numerosDeObrasArray[$xRow];
                } else {
                    $numerosDeObras .= $numerosDeObrasArray[$xRow] . ', ';
                }
            }
        }




        $activeSheet2 = $ex->setActiveSheetIndex(1);
        $activeSheet2->setCellValue('B3', 'Obra(s): '.$numerosDeObras);
        $activeSheet = $ex->setActiveSheetIndex(0);

        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=Lista_Materiais_retirada_".date('Y-m-d_H:i').".xls");
        header("Content-Transfer-Encoding: binary ");
        $objWriter = \PHPExcel_IOFactory::createWriter($ex, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }    

    public function exportarGeralExcel(Request $request)
    {
        $this->authorize('EXPORTAR_CONSULTA_OBRA');
        $data = Obra::filterObra($request->all(), true)
                        ->leftJoin('funcionarios as ff', 'ff.id', '=', 'obra.funcionario_fiscal_id')
                        ->leftJoin('funcionarios as fs', 'fs.id', '=', 'obra.funcionario_supervisor_id')
                        ->select('obra.id as id','obra.numero_obra as numero_obra','obra.data_recebimento as data_recebimento','obra.data_abertura as data_abertura' ,'obra.prazo_execucao_inicio as inicio','obra.prazo_execucao_fim as termino','obra.data_previsao_retirada_material as ret_material','prioridade.nome as prioridade','cid.nome as nome_cidade','status.nome as status_obra', 'obra.observacao as observacao', \DB::raw("string_agg(func.nome || ' ' ||func.sobrenome, '; ') as encarregados"), 'obra.tipo_setor_obra_id as tipo_setor_obra_id',\DB::raw("ff.nome ||' '|| ff.sobrenome as funcionario_fiscal") , \DB::raw("fs.nome ||' '|| fs.sobrenome as funcionario_supervisor"), 'obra.cidade_id as cidade_id',\DB::raw("string_agg(ta.descricao, '; ') as apoios"), 'obra.tipo_obra_id as tipo_obra_id', 'obra.medidor as medidor', 'obra.instalacao as instalacao', 'obra.valor_orcado as valor_orcado')
                        ->groupBy('obra.id', 'prioridade.nome', 'cid.nome', 'status.nome','ff.nome', 'ff.sobrenome', 'fs.nome','fs.sobrenome')
                        ->get();

        $excel = \Excel::create('export_obra', function($excel) use ($data) {

            $excel->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $excel->sheet('Plan 1', function($sheet) use ($data)
            {
                $sheet->cell('A2:X2', function($cell) {
                    $cell->setFontWeight('bold');
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setBackground('#FFFFFF');
                });

                $sheet->cell('A:X', function($cell) {
                    $cell->setValignment('center');
                });

                $sheet->mergeCells('A1:X1');
                $sheet->setHeight(1, 53);
                $sheet->setBorder('A2:X2', 'thin');
                
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
                $sheet->setCellValue('B2', 'Pes');
                $sheet->setCellValue('C2', 'Book Fotográfo');
                $sheet->setCellValue('D2', 'Status');
                $sheet->setCellValue('E2', 'Prioridade');
                $sheet->setCellValue('F2', 'Setor');
                $sheet->setCellValue('G2', 'Regional');
                $sheet->setCellValue('H2', 'Cidade');
                $sheet->setCellValue('I2', 'Tipo');
                $sheet->setCellValue('J2', 'Valor Orçado');
                $sheet->setCellValue('K2', 'Valor Pago');
                $sheet->setCellValue('L2', 'Valor Medido');
                $sheet->setCellValue('M2', 'Data Abertura');
                $sheet->setCellValue('N2', 'Data Recebimento');
                $sheet->setCellValue('O2', 'Início Execução');
                $sheet->setCellValue('P2', 'Término');
                $sheet->setCellValue('Q2', 'Previsão Retirada Material');
                $sheet->setCellValue('R2', 'Supervisor');
                $sheet->setCellValue('S2', 'Fiscal');
                $sheet->setCellValue('T2', 'Encarregado(s)');
                $sheet->setCellValue('U2', 'Apoio(s)');
                $sheet->setCellValue('V2', 'Medidor');
                $sheet->setCellValue('W2', 'Instalação');
                $sheet->setCellValue('X2', 'Observação');
                $sheet->setHeight(2, 40.5);
                $sheet->getStyle('X1:X9999')->getAlignment()->setWrapText(true);

                $sheet->setAutoSize(array(
                    'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'V', 'W'
                ));

                $sheet->setWidth(array(
                    'T' => 75,
                    'U' => 75,
                    'X' => 75,
                ));


                for ($iRow = 3; $iRow < count($data) + 3; $iRow++){

                    $encarregados_array = explode('; ', $data[$iRow-3]->encarregados);
                    if(count($encarregados_array) > 0 && $encarregados_array[0] != ''){
                        $encarregados_array = array_unique($encarregados_array);
                    }else{
                        array_push($encarregados_array, "");
                    }

                    $apoios_array = explode('; ', $data[$iRow-3]->apoios);
                    if(count($apoios_array) > 0 && $apoios_array[0] != ''){
                        $apoios_array = array_unique($apoios_array);
                    }else{
                        array_push($apoios_array, "");
                    }

                    $sheet->setCellValue('A' . $iRow, $data[$iRow-3]->numero_obra);
                    $sheet->setCellValue('D' . $iRow, $data[$iRow-3]->status_obra);
                    $sheet->setCellValue('E' . $iRow, $data[$iRow-3]->prioridade);
                    $sheet->setCellValue('F' . $iRow, $data[$iRow-3]->setorObra->descricao);
                    $sheet->setCellValue('G' . $iRow, $data[$iRow-3]->cidade->regional->descricao);
                    $sheet->setCellValue('H' . $iRow, $data[$iRow-3]->nome_cidade);
                    $sheet->setCellValue('I' . $iRow, $data[$iRow-3]->tipoObra->descricao);
                    $sheet->setCellValue('J' . $iRow, number_format($data[$iRow-3]->valor_orcado,2,",","."));
                    $sheet->setCellValue('K' . $iRow, number_format($data[$iRow-3]->getValorPago(),2,",","."));
                    $sheet->setCellValue('L' . $iRow, number_format($data[$iRow-3]->getValorMedido(),2,",","."));
                    $sheet->setCellValue('M' . $iRow, dateToView($data[$iRow-3]->data_abertura));
                    $sheet->setCellValue('N' . $iRow, dateToView($data[$iRow-3]->data_recebimento));
                    $sheet->setCellValue('O' . $iRow, dateToView($data[$iRow-3]->inicio, true));
                    $sheet->setCellValue('P' . $iRow, dateToView($data[$iRow-3]->termino, true));
                    $sheet->setCellValue('Q' . $iRow, dateToView($data[$iRow-3]->ret_material));
                    $sheet->setCellValue('R' . $iRow, $data[$iRow-3]->funcionario_supervisor);
                    $sheet->setCellValue('S' . $iRow, $data[$iRow-3]->funcionario_fiscal);
                    $sheet->setCellValue('T' . $iRow, $encarregados_array[0] != '' ? implode(", ", $encarregados_array) : "");
                    $sheet->setCellValue('U' . $iRow, $apoios_array[0] != '' ? implode(", ", $apoios_array) : "");
                    $sheet->setCellValue('V' . $iRow, $data[$iRow-3]->medidor);
                    $sheet->setCellValue('W' . $iRow, $data[$iRow-3]->instalacao);
                    $sheet->setCellValue('X' . $iRow, $data[$iRow-3]->observacao);
                }
            });
        })->string('xlsx');

        $response =  array(
            'success' => true,
            'name' => "Obra_Geral_".date('Y-m-d_H:i').".xlsx",
            'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,".base64_encode($excel)
        );

        return response()->json($response);
    }

    public function conferirMaterialOrçado(Request $request){
        $arquivo = $request->file('arquivo');

        $dados = Excel::load($arquivo, function ($reader) { })->toObject();

        foreach ($dados as $row) {
            
            if(!isset($row->codigo) && !isset($row->descricao) && !isset($row->qtd_orc)){
                return response()->json(['success' => false, 'msg' => 'Arquivo fora do padrão, por favor ajuste o arquivo para realizar a importação.', 'modelo' => false]);
            }else if( isset($row->qtd_orc) && $row->qtd_orc < 0){
                return response()->json(['success' => false, 'msg' => 'Planilha possui valores negativos, favor verificar.']);
            }
        }
    }

    public function documentsExport(Request $request , $id){
        $obraNumero = Obra::where('obra.id', $id)->select('numero_obra')->first();
        $obra = Obra::find($id);

        $folder    =  public_path() . '/storage/documetos-anexados/obra/'. $obra->numero_obra;
        if(is_dir($folder))
        {
            $allFiles = \File::allFiles(public_path() . '/storage/documetos-anexados/obra/' . $obra->numero_obra);
        }else{
            $allFiles = [];
        }


        return view('pages.obra.documents-export', compact('id', 'allFiles', 'obra'));
    }

    public function storeDocuments(Request $request){

        $id = $request->input('id');
        $obra = Obra::find($id);

        if (!$request->hasFile('files')){
            return response()->json(['success' => false, 'msg' => 'Nenhum Arquivo(s) foi selecionado!' ]);
        }

        if($request->hasFile('files')){

            $files = $request->file('files');
            $folder    =  public_path() . '/storage/documetos-anexados/obra/' . $obra->numero_obra;

            if(!Storage::directories($folder))
            {
                Storage::makeDirectory('public/documetos-anexados/obra/' . $obra->numero_obra);
            }

            $sizeAllFiles = 0;

            foreach($files as $file){
                // Tamanho da array de arquivos (em bytes).
                $sizeAllFiles += $file->getSize();

                $validextensions = ['xls', 'xlsx', 'docx', 'doc', 'pdf', 'jpg', 'jpeg', 'png', 'txt'];

                $extension = $file->getClientOriginalExtension();

                if(!in_array( strtolower($extension), $validextensions)){
                    return response()->json(['success' => false, 'msg' => 'Arquivo(s) com extensão invalida' ]);
                }
            }

            if($sizeAllFiles > 10485760){
                return response()->json(['success' => false, 'msg' => 'O(s) arquivo(s) não pode(m) exceder o tamanho de 10MB.' ]);
            }

            foreach($files as $file){
                try {

                        $nameHash = hash("md5", uniqid(time()));

                        $extension = $file->getClientOriginalExtension();

                        $documents = $id.'_' .$nameHash. '.'.$extension;

                        if(!$file->move($folder, $documents)){
                            return response()->json(['success' => false, 'msg' => 'Erro ao salvar arquivo(s)' ]);
                        }

                } catch (Exception $exc) {
                    return response()->json(['success' => false, 'msg' => $exc->getMessage() ]);
                }
            }
            return response()->json(['success' => true, 'msg' => 'Arquivo(s) salvo(s) com sucesso!' ]);
        }
    }

    public function deleteDocuments(Request $request){

        $arquivo = \File::glob(public_path('storage/documetos-anexados/obra/' .$request->obra.'/'.$request->id), GLOB_MARK);
        $save = \File::delete($arquivo);

        if($save)
        {
            return response()->json(['success' => true, 'msg' => 'Documento excluido com sucesso. ']);
        }else{
            return response()->json(['success' => false, 'msg' => 'Erro ao excluir Documento.']);
        }
    }

    public function downloadDocuments(Request $request){

        $file  =  public_path() . '/storage/documetos-anexados/obra/' . $request->obra.'/'.$request->id;
        $contents = \File::get($file);
        $ext = $request->input('ext');
        //dd($contents);

        $headers = [ 'Content-Type' => 'application/octet-stream' ];

        $response =  array(
            'success' => true,
            'name' => $request->id,
            'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,".base64_encode($contents)
        );

        return response()->json($response);
    }

    public function imagens($id)
    {
        $obra = Obra::find($id);

        if($obra)
        {
            $imagemObra = $obra->getImagensObra();
            return response()->json($imagemObra);

        }else{
            return Response()->json('Nenhum Registro.');
        }

    }
}


