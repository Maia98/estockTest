<?php

namespace App\Http\Controllers;

use App\Model\ApontamentoMedicao;
use App\Model\ItensApontamentoMedicao;
use Illuminate\Http\Request;
use App\Model\Obra;
use App\Model\StatusObra;
use App\Model\Funcionario;
use App\Model\TipoSetorObra;
use App\Model\TipoStatusMedicao;
use App\Model\TipoMaoDeObra;
use App\Model\Empresa;
use App\Model\ValorUS;
use App\Model\Medicao;
use App\Model\ItensMedicao;
use App\Model\RegistroHistoricoObra;

class MedicaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('CONSULTAR_MEDICAO');
        $statusMedicao = TipoStatusMedicao::all()->toArray();
        $apontamentos = ApontamentoMedicao::all()->toArray();
        $funcionarios = Funcionario::select('id', \DB::raw("nome || ' ' || sobrenome as nome"))->where('fiscal', true)->get()->toArray();

        $result = Medicao::filterMedicao($request->all())->orderBy('data_medicao', 'desc')->orderBy('medicao.created_at', 'desc')->paginate(10);
        
        return view('pages.medicao.index', compact('result','statusMedicao', 'funcionarios', 'apontamentos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('CADASTRAR_MEDICAO');
        $obra = obra::all()->toArray();
        $apontamentoMedicao = ApontamentoMedicao::all()->toArray();
        $setorObra = TipoSetorObra::all()->toArray();
        $tipoMaoObra = TipoMaoDeObra::all()->toArray();
        $fiscal = Funcionario::select('id', \DB::raw("nome || ' ' || sobrenome as nome"))->where('fiscal', true)->get()->toArray();
        $statusMedicao = TipoStatusMedicao::all()->toArray();
        $valorUS = ValorUS::first();

        return view('pages.medicao.form', compact('obra','setorObra','tipoMaoObra','fiscal','statusMedicao', 'valorUS', 'apontamentoMedicao'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('CADASTRAR_MEDICAO');
        $id = $request->input('id');
        $dadosMedicao = json_decode($request->input('dados_medicao'));
        $apontamentos = explode(',', $request->input('apontamentos'));
        $medicao = Medicao::find($id);
        $errors = 0;

        if(!$medicao){
            $medicao = new Medicao();
        }

        $medicao->fill($request->all());
        $medicao->data_medicao = dateToSave($medicao->data_medicao);

        $validade = validator($request->all(), $medicao->rules(), $medicao->msgRules);

        if($validade->fails())
        {
            return response()->json(['success' => false, 'msg' => arrayToValidator($validade->getMessageBag())]);
        }

        $medicao->usuario_id = \Auth::user()->id; 

        if(count($dadosMedicao) <= 0) {
            return response()->json(['success' => false, 'msg' => 'Mão de obra não adicionada.']);
        }
        
        $save = $medicao->save();

        if($save){
            // salvando no historico da obra a medição
            RegistroHistoricoObra::registerHistorico(Obra::find($medicao->obra_id), 'Medição Cadastrada');
        }        

        $itensMedicao = ItensMedicao::where('medicao_obra_id', $medicao->id);

        for ($i=0; $i < count($dadosMedicao) ; $i++) { 
            $itensMedicao = new ItensMedicao();
            $itensMedicao->medicao_id  = $medicao->id;
            $itensMedicao->cod_mobra        = $dadosMedicao[$i]->cod_mobra;
            $itensMedicao->tipo_mao_obra_id = $dadosMedicao[$i]->tipo_mao_obra;
            $itensMedicao->nome_mobra       = $dadosMedicao[$i]->nome_mao_obra;
            $itensMedicao->descricao_mobra  = $dadosMedicao[$i]->descricao_mao_obra;
            $itensMedicao->qtde             = $dadosMedicao[$i]->quantidade;
            $itensMedicao->valor_us         = $dadosMedicao[$i]->valor_us;
            $itensMedicao->valor_unitario   = $dadosMedicao[$i]->valor_unitario;
            $itensMedicao->sub_total        = $dadosMedicao[$i]->sub_total;

            $save = $itensMedicao->save();

            if(!$save){
                $errors++;
            }
        }

        foreach ($apontamentos as $apontamento)
        {
            $itemApontamento = new ItensApontamentoMedicao();
            $itemApontamento->medicao_id = $medicao->id;
            $itemApontamento->apontamento_medicao_id = $apontamento;

            $save = $itemApontamento->save();

            if(!$save)
            {
                $errors++;
            }
        }

        if($errors <= 0 )
        {
            return response()->json(['success' => true, 'msg' => 'Medição cadastrada com sucesso.','result' => $medicao]);
        }else{
            return response()->json(['success' => false, 'msg' => 'Erro ao cadastrar Medição.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('CONSULTAR_DETALHES_MEDICAO');

        $dadosMedicao = Medicao::find($id);
        $itensMedicao = ItensMedicao::where('medicao_id', $id)->get();
        $itensApontamento = ItensApontamentoMedicao::join('apontamento_medicao', 'apontamento_medicao.id', '=', 'itens_apontamento_medicao.apontamento_medicao_id')
                                                    ->select('apontamento_medicao.nome')
                                                    ->where('medicao_id', $id)
                                                    ->get()
                                                    ->toArray();

        if(count($itensApontamento > 0))
        {
            $itensApontamento =  implode(', ', array_column($itensApontamento, 'nome'));
        }else{
            $itensApontamento = '';
        }

        $totalMedicao = ItensMedicao::select(\DB::raw('SUM (sub_total) as total'))
                                     ->where('medicao_id', $id)
                                     ->first()->total;


        return view('pages.medicao.detalhe-medicao', compact('dadosMedicao', 'itensMedicao', 'totalMedicao', 'itensApontamento'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function sourceDados(Request $request){
        $filter = $request->input('filterValue').'%';
        $tipoFiltro = $request->input('typeFilter');
        $result = \DB::table('dados_medicao')->select('cod_mobra', 'nome','descricao', 'instalar', 'retirar','instalar_emergencial', 'retirar_emergencial');
        
        if($tipoFiltro == 0){
            $result = $result->whereRaw("CAST(cod_mobra AS VARCHAR(9)) LIKE '$filter' ");
        
        }else {
            $result = $result->where('descricao','ilike', $filter);
        }
         
        
        $result = $result->get()->toArray();
        
        return response()->json(['result' => $result]);
    }

    public function exportarExcel(Request $request)
    {
        $this->authorize('EXPORTAR_CONSULTA_MEDICAO');
        $dataAtual = date('Y-m-d_H-i');
        
        $data = Medicao::filterMedicao($request->all());
        $data = $data->join('tipo_status_medicao as tsm', 'tsm.id', '=', 'medicao.status_medicao_id')
                     ->join('funcionarios as func', 'func.id', '=', 'medicao.funcionario_fiscal_id')
                     ->select('obra.numero_obra as numero_obra', \DB::RAW("TO_CHAR(medicao.data_medicao,'DD/MM/YYYY') as \"data_execucao\"") , 
                        'tsm.nome as status_medicao', \DB::RAW("CONCAT(func.nome, ' ', func.sobrenome) as \"fiscal\""), 'valor_pago AS valor_pago',\DB::raw('SUM(dm.sub_total) as "valor_medido" '),
                         \DB::raw("string_agg(am.nome, ', ') as apontamentos"))
                     ->groupBy('medicao.id', 'obra.numero_obra', 'tsm.nome','func.nome', 'func.sobrenome')
                     ->orderBy('medicao.id')
                     ->get()
                     ->toArray();

        $excel =  \Excel::create('Medição_'.$dataAtual, function($excel) use ($data) {
            $excel->sheet('Plan 1', function($sheet) use ($data)
            {
                $sheet->cell('A2:G2', function($cell) {
                    $cell->setFontWeight('bold');
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setBackground('#FFFFFF');
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
                $sheet->setCellValue('B2', 'Data Execução');
                $sheet->setCellValue('C2', 'Status');
                $sheet->setCellValue('D2', 'Fiscal');
                $sheet->setCellValue('E2', 'Valor Pago');
                $sheet->setCellValue('F2', 'Valor Medido');
                $sheet->setCellValue('G2', 'Apontamentos');
                $sheet->setHeight(2, 40.5);

                for ($iRow = 3; $iRow < count($data) + 3; $iRow++){
                    $sheet->setCellValue('A' . $iRow, $data[$iRow-3]['numero_obra']);
                    $sheet->setCellValue('B' . $iRow, $data[$iRow-3]['data_execucao']);
                    $sheet->setCellValue('C' . $iRow, $data[$iRow-3]['status_medicao']);
                    $sheet->setCellValue('D' . $iRow, $data[$iRow-3]['fiscal']);
                    $sheet->setCellValue('E' . $iRow, $data[$iRow-3]['valor_pago']);
                    $sheet->setCellValue('F' . $iRow, $data[$iRow-3]['valor_medido']);
                    $sheet->setCellValue('G' . $iRow, $data[$iRow-3]['apontamentos']);
                }
            });
        })->string('xlsx');

        $response =  array(
            'success' => true,
            'name' => "Medição_".$dataAtual.".xlsx",
            'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,".base64_encode($excel)
        );

        return response()->json($response);
    } 

    public function exportarPdf(Request $request)
    {

        $this->authorize('EXPORTAR_CONSULTA_MEDICAO');
        $titulo = "Medições";
        $result = Medicao::filterMedicao($request->all())->orderBy('id')->get();
        $name = "Gerenciar_Medição_"." ".date('Y-m-d_H-i');
        $route = 'pages.medicao.export-pdf';
        if(count($result) == 0){
            notify()->flash('Não foi possível Gerar o PDF.', 'danger');
            return back()->withInput();
        }else{
            return exportPdf($titulo, $result, $name, $route, 'landscape');
        }

    }

    public function exportarDetalhesExcel($id)
    {
        $this->authorize('EXPORTAR_DETALHES_MEDICAO');

        $dataAtual = date('Y-m-d_H-i');
        
        $data = ItensMedicao::select('tmb.nome as tipo_mao_obra', 'cod_mobra as codigo', 'descricao_mobra as desc_servico', 'qtde as qtde', 'valor_unitario as valor_unit', 'sub_total as subtotal' )->join('tipo_mao_de_obra as tmb', 'tmb.id', '=', 'itens_medicao.tipo_mao_obra_id')->where('medicao_id', $id)->get();

        return \Excel::create('Detalhe_Medição_'.$dataAtual, function($excel) use ($data) {
            $excel->sheet('Plan 1', function($sheet) use ($data)
            {
                $sheet->cell('A2:F2', function($cell) {
                    $cell->setFontWeight('bold');
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setBackground('#FFFFFF');
                });
                $sheet->mergeCells('A1:F1');
                $sheet->setHeight(1, 53);
                $sheet->setBorder('A2:F2', 'thin');
                
                $file = \File::allFiles(public_path().'\storage\imagens\empresa\\');
                if(count($file) > 0){
                    $imageToExcel = new \PHPExcel_Worksheet_Drawing;
                    $imageToExcel->setName('Logo');
                    $imageToExcel->setDescription('Logo');
                    $imageToExcel->setPath($file[0]->getRealPath());
                    $imageToExcel->setHeight(70); 
                    $imageToExcel->setCoordinates('A1');
                    $imageToExcel->setWorksheet($sheet);
                }
                $sheet->setCellValue('A2', 'Tipo Mão de Obra');
                $sheet->setCellValue('B2', 'Código');
                $sheet->setCellValue('C2', 'Descrição Serviço');
                $sheet->setCellValue('D2', 'Qtde');
                $sheet->setCellValue('E2', 'Valor Unitário');
                $sheet->setCellValue('F2', 'Subtotal');
                $sheet->setHeight(2, 40.5);

                for ($iRow = 3; $iRow < count($data) + 3; $iRow++){
                    $sheet->setCellValue('A' . $iRow, $data[$iRow-3]['tipo_mao_obra']);
                    $sheet->setCellValue('B' . $iRow, $data[$iRow-3]['codigo']);
                    $sheet->setCellValue('C' . $iRow, $data[$iRow-3]['desc_servico']);
                    $sheet->setCellValue('D' . $iRow, $data[$iRow-3]['qtde']);
                    $sheet->setCellValue('E' . $iRow, $data[$iRow-3]['valor_unit']);
                    $sheet->setCellValue('F' . $iRow, $data[$iRow-3]['subtotal']);
                }
            });
        })->download('xlsx');
    } 

    public function exportarDetalhesPdf(Request $request, $id)
    {
        $this->authorize('EXPORTAR_DETALHES_MEDICAO');

        $numero_obra = Medicao::join('obra as obra', 'obra.id', '=', 'medicao.obra_id')
                              ->where('medicao.id', $id)
                              ->select('obra.numero_obra', \DB::RAW("TO_CHAR(medicao.data_medicao,'DD/MM/YYYY') as \"data_medicao\""))->first();

        $titulo = "Itens Medição Obra Nº " . $numero_obra->numero_obra . " - Data Execução: " . $numero_obra->data_medicao;
        $result = ItensMedicao::where('medicao_id', $id)->get();
        $name = "Detalhe_Medição_".date('Y-m-d_H-i');
        $route = 'pages.medicao.export-pdf-detalhe';

        if(count($result) == 0){
            notify()->flash('Não foi possível Gerar o PDF.', 'danger');
            return back()->withInput();
        }else{
            return exportPdf($titulo, $result, $name, $route, 'landscape');
        }

    }

    public function createValorPago($id)
    {
        $this->authorize('CADASTRAR_MEDICAO');
        $valorPago = Medicao::find($id);
        $valorPago->valor_pago = number_format($valorPago->valor_pago,2,",",".");

        return view ('pages.medicao.valor-pago', compact('valorPago'));
    }

    public function storeValorPago(Request $request)
    {
        $this->authorize('CADASTRAR_MEDICAO');
        $id = $request->input('id');

        $medicao = Medicao::find($id);
        $medicao->valor_pago = $request->input('valor_pago');
        
        $result =  $medicao->save();
        
        if($result){
            $mensagem = 'Valor Pago R$'.number_format($medicao->valor_pago,2,",",".").' a Medição Nº:' ;
            try {
                RegistroHistoricoObra::registerHistorico(Obra::find($medicao->obra_id),$mensagem);
            
            } catch (Exception $e) {
                return response()->json(['success' => true, 'msg' => 'Valor Salvo, mas nao adicionado ao histórico, salve novamente ou insira o historico manualmente']);
            }
            
            return response()->json(['success' => true, 'msg' => 'Valor Recebido cadastrado com sucesso.']);
        
        }else{
            
            return response()->json(['success' => false, 'msg' => 'Erro ao salvar Valor Recebido.']);
        }
    }
}
