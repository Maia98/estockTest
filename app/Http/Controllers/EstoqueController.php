<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Estoque;
use App\Model\Almoxarifado;
use App\Model\TipoMaterial;
use App\Model\Regional;

class EstoqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('CONSULTAR_ESTOQUE');
        // Pega os valores do filtro
        $material     = $request->input('materiais');
        $regional     = $request->input('regional');
        $almoxarifado = $request->input('almoxarifado');
        $numero_obra = $request->input('numero_obra');

        // Retorna para a View os valores para o select
        $tipoMaterial  = TipoMaterial::select('id',\DB::raw("CONCAT(codigo, ' | ', descricao) as descricao"))->get()->toArray();
        $almoxarifados = Almoxarifado::all()->toArray();
        $regionais     = Regional::all()->toArray();

        $result = Estoque::getEstoqueAll($material, $regional, $almoxarifado, $numero_obra)->orderBy('mat.descricao')->paginate(10);
        

        $result = $result->setPath('')->appends($request->query());

        return view('pages.estoque.index', compact('almoxarifados', 'tipoMaterial', 'regionais', 'result'));
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
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $this->authorize('CONSULTAR_ESTOQUE');
        $id = $request->input('id');
        $regional = $request->input('regional_id');
        $almoxarifado = $request->input('almoxarifado_id');
        $obra_id = $request->input('obra_id');
        $material = TipoMaterial::select('id','codigo','descricao')->find($id);
        if($material) {
            $result = Estoque::getEstoqueDetail($id, $regional, $almoxarifado, $obra_id)->get();
            return view('pages.estoque.details', compact('result', 'material'));
        }else{
            return response()->json(['success' => false, 'msg' => 'Material Não cadastrado!']);
        }
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

    public function getAlmoxarifado(Request $request)
    {
        $cidade_id = $request->input('local_id');

        $result = Regional::join('cidade', 'cidade.regional_id', '=', 'regional.id')
                          ->join('almoxarifado', 'almoxarifado.cidade_id', '=', 'cidade.id');
        
        if($cidade_id > 0){
           $result = $result->where('regional.id', $cidade_id);
        }
        $result = $result->orderBy('almoxarifado.nome')
                         ->get()
                         ->toArray();

        return response()->json($result); 
    }

    public function exportarExcel(Request $request)
    {
        $this->authorize('EXPORTAR_ESTOQUE');
        // Pega os valores do filtro
        $material     = $request->input('materiais');
        $regional     = $request->input('regional');
        $almoxarifado = $request->input('almoxarifado');

        // Retorna para a View os valores para o select
        $tipoMaterial  = TipoMaterial::select('id',\DB::raw("CONCAT(codigo, ' | ', descricao) as descricao"))->get()->toArray();
        $almoxarifados = Almoxarifado::all()->toArray();
        $regionais     = Regional::all()->toArray();
        
        $data = Estoque::getEstoqueAll($material,$regional,$almoxarifado)->get();

        $excel = \Excel::create('export_estoque_material', function($excel) use ($data) {
            $excel->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $excel->sheet('Plan 1', function($sheet) use ($data)
            {
                $sheet->cell('A2:D2', function($cell) {
                    $cell->setFontWeight('bold');
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setBackground('#FFFFFF');
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

                $sheet->setCellValue('A2', 'Código');
                $sheet->setCellValue('B2', 'Material');
                $sheet->setCellValue('C2', 'Qtde.');
                $sheet->setCellValue('D2', 'Unidade');
                $sheet->setHeight(2, 40.5);

                
                for ($iRow = 3; $iRow < count($data) + 3; $iRow++){
                    $sheet->setCellValue('A' . $iRow, $data[$iRow-3]['codigo']);
                    $sheet->setCellValue('B' . $iRow, $data[$iRow-3]['nomeMaterial']);
                    $sheet->setCellValue('C' . $iRow, $data[$iRow-3]['quantidade']);
                    $sheet->setCellValue('D' . $iRow, $data[$iRow-3]['codigo_unidade']);
                }

            });
        })->string('xlsx');

        $response =  array(
            'success' => true,
            'name' => "Material_Estoque_".date('Y-m-d_H:i').".xlsx",
            'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,".base64_encode($excel)
        );

        return response()->json($response);
    }

    public function exportarPdf(Request $request)
    {
        $this->authorize('EXPORTAR_ESTOQUE');
        $titulo = 'Material Estoque';

        // Pega os valores do filtro
        $material     = $request->input('materiais');
        $regional     = $request->input('regional');
        $almoxarifado = $request->input('almoxarifado');

        // Retorna para a View os valores para o select
        $tipoMaterial  = TipoMaterial::select('id',\DB::raw("CONCAT(codigo, ' | ', descricao) as descricao"))->get()->toArray();
        $almoxarifados = Almoxarifado::all()->toArray();
        $regionais     = Regional::all()->toArray();
        
        $result = Estoque::getEstoqueAll($material,$regional,$almoxarifado)->get();

        $name   = "Material_Estoque_".date('Y-m-d_H-i');
        $route = 'pages.estoque.export-pdf';

        if(count($result) == 0){
            notify()->flash('Não foi possível Gerar o PDF.', 'danger');
            return back()->withInput();
        }else{
            return exportPdf($titulo, $result, $name,$route);
        }
        
    }

}
