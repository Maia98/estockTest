<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\TipoStatusMedicao;
use Barryvdh\DomPDF\PDF;


class TipoStatusMedicaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('CONSULTAR_TABELAS_SISTEMA');

        $filter = $request->input('filtro_input');

        $result = TipoStatusMedicao::orderBy('id');

        if($filter){
            $filter_like = "%".$filter."%";

            $result = $result->where('nome','ilike',$filter_like);
        }

        $result = $result->paginate(10);

        return view('pages.tipo-status-medicao.index', compact('result', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('CADASTRAR_TABELAS_SISTEMA');

        return view('pages.tipo-status-medicao.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('CADASTRAR_TABELAS_SISTEMA');

        $id = $request->input('id');

        $tipoStatusMedicao = TipoStatusMedicao::find($id);

        if(!$tipoStatusMedicao){
            $tipoStatusMedicao = new TipoStatusMedicao();
        }

        $tipoStatusMedicao->fill($request->all());

        $validade = validator($request->all(), $tipoStatusMedicao->rules(), $tipoStatusMedicao->msgRules);

        if($validade->fails())
        {
            return response()->json(['success' => false, 'msg' => arrayToValidator($validade->getMessageBag())]);
        }

        $save = $tipoStatusMedicao->save();
        
        if($save)
        {
            return response()->json(['success' => true, 'msg' => 'Tipo Status Medição com sucesso.', 'result' => $tipoStatusMedicao]);
        }else{
            return response()->json(['success' => false, 'msg' => 'Erro ao cadastrar Tipo Status Medição.']);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoStatusMedicao $tipoStatusMedicao)
    {
        $this->authorize('CADASTRAR_TABELAS_SISTEMA');

        return view('pages.tipo-status-medicao.form', compact('tipoStatusMedicao'));
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
    
    public function delete(TipoStatusMedicao $tipoStatusMedicao)
    {
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');

        return view('pages.tipo-status-medicao.delete', compact('tipoStatusMedicao'));
    }



    public function destroy(Request $request)
    {
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');

        $id = $request->input('id');

        try {
            $detete = \DB::table('tipo_status_medicao')
                           ->where('id', $id)
                           ->delete();
            if($detete)
            {
                notify()->flash('Tipo Status Medição excluido com sucesso.', 'success');
            
            }else{
                
                notify()->flash('Erro ao excluir Tipo Status Medição.', 'danger');
            }
        } catch (\Exception $exc) {
            if( $exc->getCode() == 23503) {
        
                notify()->flash('Não é possivel excluir Tipo Status Medição em uso.', 'danger');
        
            }else{
        
                notify()->flash('Erro ao excluir Tipo Status Medição.', 'danger');
            }
        } finally {

            return redirect()->action('TipoStatusMedicaoController@index');  
            
        }  
    }
    // function import pdf and excel


    // public function exportarExcel(Request $request)
    // {
        
    //     $data = TipoStatusMedicao::select('id as Id', 'nome as Nome')->orderBy('id')->get()->toArray();
    //     return \Excel::create('export_tipo_status_medicao', function($excel) use ($data) {
    //         $excel->sheet('Plan 1', function($sheet) use ($data)
    //         {
    //             $sheet->fromArray($data);
    //         });
    //     })->download('xlsx');
    // }

    // public function exportarPdf(Request $request)
    // {

    //     $result = TipoStatusMedicao::select('id', 'nome')->orderBy('id')->get();
    //     $titulo = "Tipo Status Medição";
        
    //     if($result){
    //         $view = \View::make('pages.tipo-status-medicao.export-pdf', compact("result", "titulo"))->render();
    //         $pdf = \PDF::loadHTML($view);
            
    //         return $pdf->stream();
    //     }else{
    //         notify()->flash('Não foi possível Gerar o PDF.', 'danger');
    //         return back()->withInput();
    //     }
    // }
}
