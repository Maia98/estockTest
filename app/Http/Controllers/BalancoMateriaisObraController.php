<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Obra;
use App\Model\Estoque;
use App\User;

class BalancoMateriaisObraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($idObra, $saldo)
    {
        $this->authorize('CONSULTAR_BALANCO_OBRA');
        $obra = Obra::where('id', $idObra)->first();

        $balanco = Obra::getBalanco($idObra, $saldo);
        if(empty($balanco)){
          $balanco = null;
        }
        $obra->formatInputs();

        return view('pages.balanco-materiais-obra.show', compact('obra', 'balanco'));
    }


    public function exportarExcel($idObra)
    {
        $this->authorize('EXPORTAR_BALANCO_OBRA');

        $data         = Obra::where('id', $idObra)->first();
        $almoxarifado = Estoque::select( \DB::raw("string_agg(distinct CAST(almoxarifado_id AS varchar), ',') as ids_almoxarifado"))
                                ->where('obra_id', $idObra)
                                ->groupBy('obra_id')
                                ->first();

        if(isset($almoxarifado)){
            //$idsAlmoxarifado = $almoxarifado->ids_almoxarifado;
            $balanco = Obra::getBalanco($idObra);

        }else{
            $balanco = [];
        }


        $excel = \Excel::create('balanco_materiais', function($excel) use ($balanco, $data) {
            $excel->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $excel->sheet('Plan 1', function($sheet) use ($balanco, $data)
            {
                $sheet->cell('A2:K2', function($cell) {
                    $cell->setFontWeight('bold');
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setBackground('#FFFFFF');
                });
                $sheet->mergeCells('A1:K1');
                $sheet->setHeight(1, 53);
                $sheet->setBorder('A2:K2', 'thin');
                
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

                $sheet->setCellValue('A2', 'Obra');
                $sheet->setCellValue('B2', 'Código Material');
                $sheet->setCellValue('C2', 'Descrição');
                $sheet->setCellValue('D2', 'Und Medida');
                $sheet->setCellValue('E2', 'Orçado');
                $sheet->setCellValue('F2', 'Entrada');
                $sheet->setCellValue('G2', 'Saída');
                $sheet->setCellValue('H2', 'Saldo');
                $sheet->setCellValue('I2', 'Trans. Entrada');
                $sheet->setCellValue('J2', 'Trans. Saída');
                $sheet->setCellValue('K2', 'Trans. Saldo');

                $sheet->setHeight(2, 40.5);
                for ($iRow = 3; $iRow < count($balanco) + 3; $iRow++){
                    $sheet->setCellValue('A' . $iRow, $balanco[$iRow-3]->numero_obra);
                    $sheet->setCellValue('B' . $iRow, $balanco[$iRow-3]->codigo);
                    $sheet->setCellValue('C' . $iRow, $balanco[$iRow-3]->descricao);
                    $sheet->setCellValue('D' . $iRow, $balanco[$iRow-3]->unidade);
                    $sheet->setCellValue('E' . $iRow, $balanco[$iRow-3]->orcado);
                    $sheet->setCellValue('F' . $iRow, $balanco[$iRow-3]->entrada);
                    $sheet->setCellValue('G' . $iRow, $balanco[$iRow-3]->saida);
                    $sheet->setCellValue('H' . $iRow, $balanco[$iRow-3]->entrada - $balanco[$iRow-3]->saida);
                    $sheet->setCellValue('I' . $iRow, $balanco[$iRow-3]->transferenciaent);
                    $sheet->setCellValue('J' . $iRow, $balanco[$iRow-3]->transferenciasai);
                    $sheet->setCellValue('K' . $iRow, $balanco[$iRow-3]->transferenciaent - $balanco[$iRow-3]->transferenciasai);
                }
                

                
            });
        })->string('xlsx');

        $response =  array(
            'success' => true,
            'name' => "Balanço_Materiais_" . $data->numero_obra . '_'.date('Y-m-d_H-i').".xlsx",
            'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,".base64_encode($excel)
        );

        return response()->json($response);

    }

    public function exportarPdf(Request $request, $idObra)
    {
        $this->authorize('EXPORTAR_BALANCO_OBRA');
        $titulo = 'Balanço da Obra';
        $result = Obra::where('id', $idObra)->first();
        $almoxarifado = Estoque::select( \DB::raw("string_agg(distinct CAST(almoxarifado_id AS varchar), ',') as ids_almoxarifado"))
                               ->where('obra_id', $idObra)
                               ->groupBy('obra_id')
                               ->first();

        if(isset($almoxarifado)){
            //$idsAlmoxarifado = $almoxarifado->ids_almoxarifado;
            $balanco = Obra::getBalanco($idObra);
        }else{

            $balanco = [];
        }           

        $name   = "Balanço_Materiais_" . $result->numero_obra . '_'.date('Y-m-d_H-i');
        $route = 'pages.balanco-materiais-obra.export-pdf';

        if(count($result) == 0){
            notify()->flash('Não foi possível Gerar o PDF.', 'danger');
            return back()->withInput();
        }else{

            return exportPdf($titulo, $result, $name, $route, "landscape", $balanco);
        }
    }
}
