<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\SaidaEstoque;
use App\Model\SaidaMaterialEstoque;

class ListaSaidaMateriaisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('CONSULTAR_LISTA_SAIDA_ESTOQUE');
        $id = $request->input('id');

        $filter = $request->input('filtro_input');

        $saida = SaidaEstoque::find($id);
        $result  = SaidaMaterialEstoque::where('saida_estoque_id', $id);

        if($filter){
            $filter_cod = "%".preg_replace("/[^0-9]/", "", $filter)."%";
            if($filter_cod == '%%'){
                $filter_cod = null;
            }
            
            $filter_des = "%".$filter."%";
            
            $result = $result->join('tipo_material as tm', 'tm.id','=','saida_material_estoque.tipo_material_id')
                             ->whereRaw("(CAST(tm.codigo AS VARCHAR(9)) ILIKE '$filter_cod' or tm.descricao ilike '$filter_des')");


        }

        $result = $result->get();
        
        return view('pages.saida-estoque.lista', compact('saida', 'result', 'filter'));
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
        $this->authorize('EXPORTAR_LISTA_SAIDA_ESTOQUE');
        $id = $request->input('id');
        $filter = $request->input('filtro_input');

        $filter_cod = "%".preg_replace("/[^0-9]/", "", $filter)."%";
        if($filter_cod == '%%'){
            $filter_cod = null;
        }
        
        $filter_des = "%".$filter."%";

        $data = SaidaMaterialEstoque::join('tipo_material as tm', 'tm.id','=','saida_material_estoque.tipo_material_id')
                                        ->join('saida_estoque as se', 'se.id', '=', 'saida_material_estoque.saida_estoque_id')
                                        ->select('tm.codigo as codigo',
                                                'tm.descricao as descricao', 
                                                'saida_material_estoque.qtde as rma',
                                                'se.obra_id',
                                                'saida_material_estoque.saida_estoque_id')
                                        ->where('saida_estoque_id', $id)
                                        ->whereRaw("(CAST(tm.codigo AS VARCHAR(9)) ILIKE '$filter_cod' or tm.descricao ilike '$filter_des')")
                                        ->orderBy('saida_material_estoque.id')
                                        ->get();

        $excel = \Excel::create('export_saida_materiais_estoque', function($excel) use ($data) {
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
                    $sheet->setCellValue('A' . $iRow, $data[$iRow-3]->saidaEstoque->obra->numero_obra);
                    $sheet->setCellValue('B' . $iRow, $data[$iRow-3]->codigo);
                    $sheet->setCellValue('C' . $iRow, $data[$iRow-3]->descricao);
                    $sheet->setCellValue('D' . $iRow, $data[$iRow-3]->rma);
                }
            });
        })->string('xlsx');

        $response =  array(
            'success' => true,
            'name' => "export_saida_materiais_estoque.xlsx",
            'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,".base64_encode($excel)
        );

        return response()->json($response);
    }

    public function exportarPdf(Request $request)
    {
        $this->authorize('EXPORTAR_LISTA_SAIDA_ESTOQUE');
        $id = $request->input('id');
        $filter = $request->input('filtro_input');

        $filter_cod = "%".preg_replace("/[^0-9]/", "", $filter)."%";
        if($filter_cod == '%%'){
            $filter_cod = null;
        }
        
        $filter_des = "%".$filter."%";

        $result = SaidaMaterialEstoque::join('tipo_material as tm', 'tm.id','=','saida_material_estoque.tipo_material_id')
                                        ->join('saida_estoque as se', 'se.id', '=', 'saida_material_estoque.saida_estoque_id')
                                        ->select('saida_material_estoque.id as id',
                                                'tm.codigo as codigo',
                                                'tm.descricao as descricao', 
                                                'saida_material_estoque.qtde as qtde',
                                                'se.obra_id',
                                                'saida_material_estoque.saida_estoque_id')
                                        ->where('saida_estoque_id', $id)
                                        ->whereRaw("(CAST(tm.codigo AS VARCHAR(9)) ILIKE '$filter_cod' or tm.descricao ilike '$filter_des')")
                                        ->orderBy('saida_material_estoque.id')
                                        ->get();

        $titulo = "Lista Saida Materiais";
        $name   = "Lista_Saida_Estoque_".date('Y-m-d_H-i');
        $route  = 'pages.saida-estoque.export-pdf-saida';

        $result2 = SaidaEstoque::find($id);
        
        if(count($result) == 0){
            notify()->flash('Não foi possível Gerar o PDF.', 'danger');
            return back()->withInput();
        }else{
            return exportPdf($titulo, $result, $name, $route, 'portrait', $result2);
        }    
    }

    public function addObs(Request $request, $id)
    {
        $this->authorize('CADASTRAR_SAIDA_ESTOQUE');

        return view('pages.saida-estoque.add-obs', compact('id'));
    }

    public function storeObs(Request $request)
    {
        $this->authorize('CADASTRAR_SAIDA_ESTOQUE');

        $id = $request->input('id');
        $obs = $request->input('observacao');

        $saida = SaidaEstoque::find($id);
        $head = \Auth::user()->name . ' ['. date('d/m/Y H:i') . ']: ';

        if($saida)
        {
            if($saida->obs)
            {
                $saida->obs = $saida->obs . "<br />" . $head . $obs;
            }else{
                $saida->obs = $head . $obs;
            }

            $saida->save();

            notify()->flash('Observação incluída com sucesso!.', 'success');
            return redirect()->action('ListaSaidaMateriaisController@index', ['id' => $id]);
        }else{

            notify()->flash('Registro não encontrado!.', 'warning');
            return redirect()->action('ListaSaidaMateriaisController@index', ['id' => $id]);
        }

    }

}
