<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\EntradaEstoque;
use App\Model\EntradaMaterialEstoque;

class ListaEntradaMateriaisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
   {
       $this->authorize('CONSULTAR_LISTA_ENTRADA_ESTOQUE');

       $id = $request->input('id');

        $filter = $request->input('filtro_input');

        $entrada = EntradaEstoque::find($id);
        $result  = EntradaMaterialEstoque::where('entrada_estoque_id', $id);

        if($filter){
            $filter_cod = "%".preg_replace("/[^0-9]/", "", $filter)."%";
            if($filter_cod == '%%'){
                $filter_cod = null;
            }
            
            $filter_des = "%".$filter."%";
            
            $result = $result->join('tipo_material as tm', 'tm.id','=','entrada_material_estoque.tipo_material_id')
                             ->whereRaw("(CAST(tm.codigo AS VARCHAR(9)) ILIKE '$filter_cod' or tm.descricao ilike '$filter_des')");


        }

        $result = $result->get();
        
        return view('pages.entrada-estoque.lista', compact('entrada', 'result', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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

    public function exportarExcel(Request $request)
    {
        $this->authorize('EXPORTAR_LISTA_ENTRADA_ESTOQUE');

        $id = $request->input('id');
        $filter = $request->input('filtro_input');
        $dataAtual = date('Y-m-d_H-i');

        $filter_cod = "%".preg_replace("/[^0-9]/", "", $filter)."%";
        if($filter_cod == '%%'){
            $filter_cod = null;
        }
        
        $filter_des = "%".$filter."%";

        $data = EntradaMaterialEstoque::join('tipo_material as tm', 'tm.id','=','entrada_material_estoque.tipo_material_id')
                                        ->join('entrada_estoque as es', 'es.id', '=', 'entrada_material_estoque.entrada_estoque_id')
                                        ->select('tm.codigo as codigo',
                                                'tm.descricao as descricao', 
                                                'entrada_material_estoque.qtde as rma',
                                                'es.obra_id',
                                                'entrada_material_estoque.entrada_estoque_id')
                                        ->where('entrada_estoque_id', $id)
                                        ->whereRaw("(CAST(tm.codigo AS VARCHAR(9)) ILIKE '$filter_cod' or tm.descricao ilike '$filter_des')")
                                        ->orderBy('entrada_material_estoque.id')
                                        ->get();

        $excel = \Excel::create('export_entrada_materiais_estoque', function($excel) use ($data) {
            $excel->sheet('Plan 1', function($sheet) use ($data)
            {
                $sheet->cell('A2:D2', function($cell) {
                    $cell->setFontWeight('bold');
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setBackground('#FFFFFF');
                });
                $sheet->mergeCells('A1:D1');
                $sheet->setHeight(1, 34);
                $sheet->setBorder('A2:D2', 'thin');
                
                $file = \File::allFiles(public_path().'/storage/imagens/empresa/');
                if(count($file) > 0){
                    $imageToExcel = new \PHPExcel_Worksheet_Drawing;
                    $imageToExcel->setName('Logo');
                    $imageToExcel->setDescription('Logo');
                    $imageToExcel->setPath($file[0]->getRealPath());
                    $imageToExcel->setHeight(44);
                    $imageToExcel->setCoordinates('A1');
                    $imageToExcel->setWorksheet($sheet);
                }
                $sheet->setCellValue('A2', 'Obra');
                $sheet->setCellValue('B2', 'Código');
                $sheet->setCellValue('C2', 'Descrição');
                $sheet->setCellValue('D2', 'RMA');
                $sheet->setHeight(2, 40.5);

                for ($iRow = 3; $iRow < count($data) + 3; $iRow++){
                    $sheet->setCellValue('A' . $iRow, $data[$iRow-3]->entradaEstoque->obra->numero_obra);
                    $sheet->setCellValue('B' . $iRow, $data[$iRow-3]->codigo);
                    $sheet->setCellValue('C' . $iRow, $data[$iRow-3]->descricao);
                    $sheet->setCellValue('D' . $iRow, $data[$iRow-3]->rma);
                }
            });
        })->string('xlsx');

        $response =  array(
            'success' => true,
            'name' => "export_entrada_materiais_estoque_".$dataAtual.".xlsx",
            'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,".base64_encode($excel)
        );

        return response()->json($response);
    }

    public function exportarPdf(Request $request)
    {
        $this->authorize('EXPORTAR_LISTA_ENTRADA_ESTOQUE');
        $id = $request->input('id');
        $filter = $request->input('filtro_input');
        $titulo = "Lista Entrada Materiais";
        $route = 'pages.entrada-estoque.export-pdf-entrada';
        $name = "Lista_Entrada_Estoque_".date('Y-m-d_H-i');

        $filter_cod = "%".preg_replace("/[^0-9]/", "", $filter)."%";
        if($filter_cod == '%%'){
            $filter_cod = null;
        }
        
        $filter_des = "%".$filter."%";

        $result = EntradaMaterialEstoque::join('tipo_material as tm', 'tm.id','=','entrada_material_estoque.tipo_material_id')
                                        ->join('entrada_estoque as es', 'es.id', '=', 'entrada_material_estoque.entrada_estoque_id')
                                        ->select('entrada_material_estoque.id as id',
                                                'tm.codigo as codigo',
                                                'tm.descricao as descricao',
                                                'entrada_material_estoque.qtde as qtde',
                                                'es.obra_id',
                                                'entrada_material_estoque.entrada_estoque_id',
                                                'es.tipo_entrada_estoque_id',
                                                'es.data', 'es.obs')
                                        ->where('entrada_estoque_id', $id)
                                        ->whereRaw("(CAST(tm.codigo AS VARCHAR(9)) ILIKE '$filter_cod' or tm.descricao ilike '$filter_des')")
                                        ->orderBy('entrada_material_estoque.id')
                                        ->get();

        $result2 = EntradaEstoque::find($id);

        if(count($result) == 0){
            notify()->flash('Não foi possível Gerar o PDF.', 'danger');
            return back()->withInput();
        }else{
            return exportPdf($titulo, $result, $name,$route,"portrait", $result2);
        }
    }

    public function addObs(Request $request, $id)
    {
        $this->authorize('CADASTRAR_ENTRADA_ESTOQUE');

        return view('pages.entrada-estoque.add-obs', compact('id'));
    }

    public function storeObs(Request $request)
    {
        $this->authorize('CADASTRAR_ENTRADA_ESTOQUE');

        $id = $request->input('id');
        $obs = $request->input('observacao');

        $entrada = EntradaEstoque::find($id);
        $head = \Auth::user()->name . ' ['. date('d/m/Y H:i') . ']: ';

        if($entrada)
        {
            if($entrada->obs)
            {
                $entrada->obs = $entrada->obs . "<br />" . $head . $obs;
            }else{
                $entrada->obs = $head . $obs;
            }

            $entrada->save();

            notify()->flash('Observação incluída com sucesso!.', 'success');
            return redirect()->action('ListaEntradaMateriaisController@index', ['id' => $id]);
        }else{

            notify()->flash('Registro não encontrado!.', 'warning');
            return redirect()->action('ListaEntradaMateriaisController@index', ['id' => $id]);
        }

    }
}
