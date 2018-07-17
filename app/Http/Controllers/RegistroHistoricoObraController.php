<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\RegistroHistoricoObra;
use App\Model\Obra;
use App\User;

class RegistroHistoricoObraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $idObra)
    {
        $this->authorize('CONSULTAR_HISTORICO_OBRA');

        $numeroObra = Obra::select('numero_obra')->where('id', $idObra)->first();

        $filter = $request->input('filtro_input');

        $result = RegistroHistoricoObra::orderBy('registro_historico_obra.id');

        if($filter){
            $result = $result->join('users as user', 'user.id', '=', 'registro_historico_obra.usuario_id')
                             ->where('obra_id', $idObra)
                             ->where(function($where) use ($filter) {
                                $where->whereRaw("CAST(TO_CHAR(registro_historico_obra.created_at,'DD/MM/YYYY HH24:MI') as VARCHAR) LIKE ?","%$filter%")
                                       ->orWhere('registro_historico_obra.status_obra','ilike', "%$filter%")
                                       ->orWhere('user.name', 'ilike', "%$filter%")
                                       ->orWhere('registro_historico_obra.descricao', 'ilike', "%$filter%");
                             })
                             ->orderBy('registro_historico_obra.created_at')
                             ->select('registro_historico_obra.id as id',
                                      'registro_historico_obra.created_at as created_at', 
                                      'registro_historico_obra.descricao as descricao', 
                                      'registro_historico_obra.status_obra as status_obra',
                                      'registro_historico_obra.usuario_id as usuario_id')
                             ->paginate(10);
        }else{
            $result = $result->where('obra_id', $idObra)->orderBy('created_at')->paginate(10);
        }
        
        return view('pages.registro-historico-obra.show', compact('result', 'numeroObra', 'filter', 'idObra'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($idObra)
    {
       $this->authorize('CADASTRAR_HISTORICO_OBRA');
       $numeroObra = Obra::select('numero_obra')->where('id', $idObra)->first();

       return view('pages.registro-historico-obra.form', compact('idObra','numeroObra'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $id = $request->input('idObra');

        $obra = Obra::find($id);

        $historicoObra = new RegistroHistoricoObra();

        $validade = validator($request->all(), $historicoObra->rules(), $historicoObra->msgRules);

        if($validade->fails())
        {
            return response()->json(['success' => false, 'msg' => arrayToValidator($validade->getMessageBag())]);
        }
        $historicoObra->obra_id = $obra->id;
        $historicoObra->usuario_id = \Auth::user()->id;;
        $historicoObra->descricao = $request->input('descricao');
        $historicoObra->status_obra = $obra->statusObra->nome;
        
        $save = $historicoObra->save();
        
        if($save)
        {
            return response()->json(['success' => true, 'msg' => 'Historico cadastrado com sucesso cadastrado com sucesso.']);
        }else{
            return response()->json(['success' => false, 'msg' => 'Erro ao cadastrar Historico.']);
        }
    }
    
    public function exportarExcel(Request $request, $idObra)
    {
        $this->authorize('EXPORTAR_HISTORICO_OBRA');
        $filter = $request->input('filtro_input');
        $data = RegistroHistoricoObra::orderBy('registro_historico_obra.id');

        if($filter){
            $data = $data->join('users as user', 'user.id', '=', 'registro_historico_obra.usuario_id')
                             ->where('obra_id', $idObra)
                             ->where(function($where) use ($filter) {
                                $where->whereRaw("CAST(TO_CHAR(registro_historico_obra.created_at,'DD/MM/YYYY HH24:MI') as VARCHAR) LIKE ?","%$filter%")
                                       ->orWhere('registro_historico_obra.status_obra','ilike', "%$filter%")
                                       ->orWhere('user.name', 'ilike', "%$filter%")
                                       ->orWhere('registro_historico_obra.descricao', 'ilike', "%$filter%");
                             })
                             ->orderBy('registro_historico_obra.created_at')
                             ->select('registro_historico_obra.id as id',
                                      'registro_historico_obra.created_at as created_at', 
                                      'registro_historico_obra.descricao as descricao', 
                                      'registro_historico_obra.status_obra as status_obra',
                                      'registro_historico_obra.usuario_id as usuario_id')
                             ->get();
        }else{
            $data = $data->where('obra_id', $idObra)->orderBy('created_at')->get();
        }

        $excel = \Excel::create('export_obra', function($excel) use ($data) {
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

                $sheet->setCellValue('A2', 'Status');
                $sheet->setCellValue('B2', 'Usuário');
                $sheet->setCellValue('C2', 'Data Movimento');
                $sheet->setCellValue('D2', 'Observações');
                $sheet->setHeight(2, 40.5);

                for ($iRow = 3; $iRow < count($data) + 3; $iRow++){
                    $sheet->setCellValue('A' . $iRow, $data[$iRow-3]->status_obra);
                    $sheet->setCellValue('B' . $iRow, $data[$iRow-3]->usuario->name);
                    $sheet->setCellValue('C' . $iRow, date("d-m-Y H:i:s", strtotime($data[$iRow-3]->created_at)));
                    $sheet->setCellValue('D' . $iRow, $data[$iRow-3]->descricao);
                }

            });

        })->string('xlsx');

        $response =  array(
            'success' => true,
            'name' => "Historico_obra_".date('Y-m-d_H:i').".xlsx",
            'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,".base64_encode($excel)
        );

        return response()->json($response);

    }

    public function exportarPdf(Request $request, $idObra)
    {
        $this->authorize('EXPORTAR_HISTORICO_OBRA');
        $titulo     = 'Registro Obra';
        $name       = "Gerenciar_obras_".date('Y-m-d_H-i');
        $route      = 'pages.registro-historico-obra.export-pdf';

        $filter = $request->input('filtro_input');
        $result = RegistroHistoricoObra::orderBy('registro_historico_obra.id');
        
        if($filter){
            $result = $result->join('users as user', 'user.id', '=', 'registro_historico_obra.usuario_id')
                             ->where('obra_id', $idObra)
                             ->where(function($where) use ($filter) {
                                $where->whereRaw("CAST(TO_CHAR(registro_historico_obra.created_at,'DD/MM/YYYY HH24:MI') as VARCHAR) LIKE ?","%$filter%")
                                       ->orWhere('registro_historico_obra.status_obra','ilike', "%$filter%")
                                       ->orWhere('user.name', 'ilike', "%$filter%")
                                       ->orWhere('registro_historico_obra.descricao', 'ilike', "%$filter%");
                             })
                             ->orderBy('registro_historico_obra.created_at')
                             ->select('registro_historico_obra.id as id',
                                      'registro_historico_obra.created_at as created_at', 
                                      'registro_historico_obra.descricao as descricao', 
                                      'registro_historico_obra.status_obra as status_obra',
                                      'registro_historico_obra.usuario_id as usuario_id')
                             ->get();
        }else{
            $result = $result->where('obra_id', $idObra)->orderBy('created_at')->get();
        }

        if(count($result) == 0){
            notify()->flash('Não foi possível Gerar o PDF.', 'danger');
            return back()->withInput();
        }else{
            return exportPdf($titulo, $result, $name,$route);
        }
    }
}
