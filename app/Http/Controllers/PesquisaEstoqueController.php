<?php

namespace App\Http\Controllers;

use App\Model\TransferenciaEstoque;
use App\Model\TransferenciaMaterialEstoque;
use Illuminate\Http\Request;
use App\Model\Estoque;
use App\Model\SaidaEstoque;
use App\Model\EntradaEstoque;
use App\Model\Almoxarifado;
use App\Model\Empresa;
use App\Model\TipoMaterial;
use App\Model\StatusObra;
use Illuminate\Pagination\LengthAwarePaginator;

class PesquisaEstoqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('CONSULTAR_PESQUISA_ESTOQUE');
        $page          = $request->input('page', 1);
        $almoxarifados = Almoxarifado::all()->toArray();
        $status_obras  = StatusObra::all()->toArray();

        $result = $this->sqlQuery($request);

        $result = paginate($page, $request, 10, $result->toArray());
        $result = $result->setPath('')->appends($request->query());

        return view('pages.estoque.pesquisa', compact('result','almoxarifados', 'status_obras'));
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
        $this->authorize('CONSULTAR_PESQUISA_ESTOQUE');
        $dataAtual = date('Y-m-d_H:i');
        $data = $this->sqlQuery($request);

        $excel = \Excel::create('export_estoque_pesquisa', function($excel) use ($data) {
            $excel->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
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

                $sheet->setCellValue('A2', 'Código');
                $sheet->setCellValue('B2', 'Descrição');
                $sheet->setCellValue('C2', 'Almoxarifado');
                $sheet->setCellValue('D2', 'Nº Obra');
                $sheet->setCellValue('E2', 'Status Obra');
                $sheet->setCellValue('F2', 'Tipo Movimento');
                $sheet->setCellValue('G2', 'Data Movimento');
                $sheet->setHeight(2, 40.5);

                for ($iRow = 3; $iRow < count($data) + 3; $iRow++){
                    $sheet->setCellValue('A' . $iRow, $data[$iRow-3]->codigo);
                    $sheet->setCellValue('B' . $iRow, $data[$iRow-3]->descricao);
                    $sheet->setCellValue('C' . $iRow, $data[$iRow-3]->almoxarifado_nome);
                    $sheet->setCellValue('D' . $iRow, $data[$iRow-3]->numero_obra);
                    $sheet->setCellValue('E' . $iRow, $data[$iRow-3]->status_obra);
                    $sheet->setCellValue('F' . $iRow, $data[$iRow-3]->tipo_movimento);
                    $sheet->setCellValue('G' . $iRow, dateToView($data[$iRow-3]->data));
                }

            });
        })->string('xlsx');

        $response =  array(
            'success' => true,
            'name' => "Pesquisa_Materiais_".$dataAtual.".xlsx",
            'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,".base64_encode($excel)
        );

        return response()->json($response);
    }

    public function exportarPdf(Request $request)
    {
        $this->authorize('CONSULTAR_PESQUISA_ESTOQUE');
        $titulo = 'Pesquisa Materiais';
        $cod_inicio     = $request->input('cod_inicio');
        $cod_final      = $request->input('cod_final');
        $numero_obra    = $request->input('numero_obra');
        $status_obra    = $request->input('status_obra');
        $almoxarifado   = $request->input('almoxarifado');
        $tipo_movimento = $request->input('tipo_movimento');
        $data_inicio    = $request->input('data_inicio');
        $data_final     = $request->input('data_final');
        $result         = null;
        $result = $this->sqlQuery($request);
        $name            = "Pesquisa_Materiais_".date('Y-m-d_H-i');
        $route  = 'pages.estoque.export-pdf-pesquisa';

        if(count($result) == 0){
            notify()->flash('Não foi possível Gerar o PDF.', 'danger');
            return back()->withInput();
        }else{
            return exportPdf($titulo, $result, $name, $route, "landscape");
        }
    }

    public function sqlQuery($request)
    {
        $cod_inicio     = $request->input('cod_inicio');
        $cod_final      = $request->input('cod_final');
        $numero_obra    = $request->input('numero_obra');
        $status_obra    = $request->input('status_obra');
        $almoxarifado   = $request->input('almoxarifado');
        $tipo_movimento = $request->input('tipo_movimento');
        $data_inicio    = $request->input('data_inicio');
        $data_final     = $request->input('data_final');

        $entrada = EntradaEstoque::join('entrada_material_estoque AS eme', 'entrada_estoque.id', '=', 'eme.entrada_estoque_id')
                                 ->join('tipo_material AS tm', 'tm.id', '=', 'eme.tipo_material_id')
                                 ->join('obra', 'obra.id', '=', 'entrada_estoque.obra_id')
                                 ->join('status_obra as tipo_obra', 'tipo_obra.id', '=', 'obra.tipo_status_obra_id')
                                 ->join('almoxarifado as alm', 'alm.id', '=', 'entrada_estoque.almoxarifado_id')
                                 ->selectRaw("tm.codigo AS codigo, tm.descricao AS descricao, entrada_estoque.almoxarifado_id AS almoxarifado, obra.numero_obra AS numero_obra, tipo_obra.nome AS status_obra, 'Entrada' AS tipo_movimento, entrada_estoque.data AS data, alm.nome as almoxarifado_nome");

        $saida   = SaidaEstoque::join('saida_material_estoque AS sme', 'saida_estoque.id', '=', 'sme.saida_estoque_id')
                                ->join('tipo_material AS tm', 'tm.id', '=', 'sme.tipo_material_id')
                                ->join('obra', 'obra.id', '=', 'saida_estoque.obra_id')
                                ->join('status_obra as tipo_obra', 'tipo_obra.id', '=', 'obra.tipo_status_obra_id')
                                ->join('almoxarifado as alm', 'alm.id', '=', 'saida_estoque.almoxarifado_id')
                                ->selectRaw("tm.codigo AS codigo, tm.descricao AS descricao, saida_estoque.almoxarifado_id AS almoxarifado, obra.numero_obra AS numero_obra, tipo_obra.nome AS status_obra, 'Saída' AS tipo_movimento, saida_estoque.data AS data, alm.nome as almoxarifado_nome");

        $transferencia = TransferenciaEstoque::join('transferencia_material_estoque AS tme', 'transferencia_estoque.id', '=', 'tme.transferencia_estoque_id')
                                            ->join('tipo_material AS tm', 'tm.id', '=', 'tme.tipo_material_id')
                                            ->join('obra', 'obra.id', '=', 'transferencia_estoque.obra_destino_id')
                                            ->join('status_obra as tipo_obra', 'tipo_obra.id', '=', 'obra.tipo_status_obra_id')
                                            ->join('almoxarifado as alm', 'alm.id', '=', 'transferencia_estoque.almoxarifado_destino_id')
                                            ->selectRaw("tm.codigo AS codigo, tm.descricao AS descricao, transferencia_estoque.almoxarifado_destino_id AS almoxarifado, obra.numero_obra AS numero_obra, tipo_obra.nome AS status_obra, 'Transferência' AS tipo_movimento, transferencia_estoque.data AS data, alm.nome as almoxarifado_nome");

        if(!empty($cod_inicio) && empty($cod_final))
        {
            if($tipo_movimento == 1)
            {
                $entrada = $entrada->where('tm.codigo', $cod_inicio);
            }
            elseif($tipo_movimento == 2)
            {
                $saida = $saida->where('tm.codigo', $cod_inicio);
            }
            elseif($tipo_movimento == 3)
            {
                $transferencia = $transferencia->where('tm.codigo', $cod_inicio);
            }
            else
            {
                $entrada = $entrada->where('tm.codigo', $cod_inicio);
                $saida = $saida->where('tm.codigo', $cod_inicio);
                $transferencia = $transferencia->where('tm.codigo', $cod_inicio);
            }
        }

        if(!empty($cod_inicio) && !empty($cod_final))
        {
            if($tipo_movimento == 1)
            {
                $entrada = $entrada->whereBetween('tm.codigo', [$cod_inicio, $cod_final]);
            }
            elseif($tipo_movimento == 2)
            {
                $saida = $saida->whereBetween('tm.codigo', [$cod_inicio, $cod_final]);
            }
            elseif($tipo_movimento == 3)
            {
                $transferencia = $transferencia->whereBetween('tm.codigo', [$cod_inicio, $cod_final]);
            }
            else
            {
                $entrada = $entrada->whereBetween('tm.codigo', [$cod_inicio, $cod_final]);
                $saida = $saida->whereBetween('tm.codigo', [$cod_inicio, $cod_final]);
                $transferencia = $transferencia->whereBetween('tm.codigo', [$cod_inicio, $cod_final]);
            }
        }


        if(!empty($numero_obra))
        {
            if($tipo_movimento == 1)
            {
                $entrada = $entrada->where('numero_obra', $numero_obra); 
            }
            elseif($tipo_movimento == 2)
            {
                $saida = $saida->where('numero_obra', $numero_obra);
            }
            elseif($tipo_movimento == 3)
            {
                $transferencia = $transferencia->where('numero_obra', $numero_obra);
            }
            else
            {
                $entrada = $entrada->where('numero_obra', $numero_obra);
                $saida = $saida->where('numero_obra', $numero_obra);
                $transferencia = $transferencia->where('numero_obra', $numero_obra);
            } 
        }

        if(!empty($status_obra))
        {   
            if($tipo_movimento == 1)
            {
                $entrada = $entrada->where('tipo_status_obra_id', $status_obra);
            }
            elseif($tipo_movimento == 2)
            {
                $saida = $saida->where('tipo_status_obra_id', $status_obra);
            }
            elseif($tipo_movimento == 3)
            {
                $transferencia = $transferencia->where('tipo_status_obra_id', $status_obra);
            }
            else
            {
                $entrada = $entrada->where('tipo_status_obra_id', $status_obra);
                $saida = $saida->where('tipo_status_obra_id', $status_obra);
                $transferencia = $transferencia->where('tipo_status_obra_id', $status_obra);
            }
        }

        if(!empty($almoxarifado))
        {
            if($tipo_movimento == 1)
            {
                $entrada = $entrada->where('entrada_estoque.almoxarifado_id', $almoxarifado); 
            }
            elseif($tipo_movimento == 2)
            {
                $saida = $saida->where('saida_estoque.almoxarifado_id', $almoxarifado); 
            }
            elseif($tipo_movimento == 3)
            {
                $transferencia = $transferencia->where('transferencia_estoque.almoxarifado_destino_id', $almoxarifado);
            }
            else
            {
                $entrada = $entrada->where('entrada_estoque.almoxarifado_id', $almoxarifado);
                $saida   = $saida->where('saida_estoque.almoxarifado_id', $almoxarifado);
                $transferencia = $transferencia->where('transferencia_estoque.almoxarifado_destino_id', $almoxarifado);
            }
        }

        if(!empty($data_inicio) && !empty($data_final))
        {
            $data_inicio = $request['data_inicio']." 00:00:00";
            $data_final  = $request['data_final']." 23:59:59";

            if($tipo_movimento == 1)
            {
                $entrada = $entrada->whereBetween('entrada_estoque.data', [$data_inicio, $data_final]); 
            } 
            elseif($tipo_movimento == 2)
            {
                $saida = $saida->whereBetween('saida_estoque.data', [$data_inicio, $data_final]); 
            }
            elseif($tipo_movimento == 3)
            {
                $transferencia = $transferencia->whereBetween('transferencia_estoque.data', [$data_inicio, $data_final]);
            }
            else
            {
                $entrada = $entrada->whereBetween('entrada_estoque.data', [$data_inicio, $data_final]);
                $saida   = $saida->whereBetween('saida_estoque.data', [$data_inicio, $data_final]);
                $transferencia = $transferencia->whereBetween('transferencia_estoque.data', [$data_inicio, $data_final]);
            }
        }



        if($tipo_movimento == 1)
        {
            $result = $entrada;
        } else if($tipo_movimento == 2)
        {
            $result = $saida;
        } else if($tipo_movimento == 3)
        {
            $result = $transferencia;
        } else
        {
            $result = $transferencia->union($entrada)->union($saida);
        }

        $result = $result->orderBy('data', 'desc')->orderBy('descricao')->get();
        
        return $result;
    }
}
