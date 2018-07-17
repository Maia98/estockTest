<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Model\TipoPrioridade;

class TipoPrioridadeController extends Controller
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

        $result = TipoPrioridade::orderBy('id');

        if($filter){
            $filter_like = "%".$filter."%";

            $result = $result->where('nome','ilike', $filter_like);
        }

        $result = $result->paginate(10);

        return view('pages.tipo-prioridade.index', compact('result', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('CADASTRAR_TABELAS_SISTEMA');

        return view('pages.tipo-prioridade.form');
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

        $tipoPrioridade = TipoPrioridade::find($id);

        if(!$tipoPrioridade){
            $tipoPrioridade = new TipoPrioridade();
        }

        $tipoPrioridade->fill($request->all());

        $validade = validator($request->all(), $tipoPrioridade->rules(), $tipoPrioridade->msgRules);

        if($validade->fails())
        {
            return response()->json(['success' => false, 'msg' => arrayToValidator($validade->getMessageBag())]);
        }

        $save = $tipoPrioridade->save();
        
        if($save)
        {
            return response()->json(['success' => true, 'msg' => 'Tipo Prioridade cadastrado com sucesso.' , 'result' => $tipoPrioridade]);
        }else{
            return response()->json(['success' => false, 'msg' => 'Erro ao cadastrar Tipo Prioridade.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoPrioridade $tipoPrioridade)
    {
        $this->authorize('CADASTRAR_TABELAS_SISTEMA');

        return view('pages.tipo-prioridade.form', compact('tipoPrioridade'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(TipoPrioridade $tipoPrioridade)
    {
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');

        return view('pages.tipo-prioridade.delete', compact('tipoPrioridade'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');

        $id = $request->input('id');

        try {
            $detete = \DB::table('tipo_prioridade')
                           ->where('id', $id)
                           ->delete();

            if($detete)
            {

                notify()->flash('Tipo Prioridade excluido com sucesso.', 'success');

            }else{

                notify()->flash('Erro ao excluir Tipo prioridade.');

            }
        } catch (\Exception $exc) {
            if( $exc->getCode() == 23503) {

                notify()->flash('Não é permitido excluir Tipo Prioridade em uso.', 'danger');   

            }else{
                
                notify()->flash('Erro ao excluir Tipo Prioridade.', 'danger');        
            }
        } finally {
            return redirect()->action('TipoPrioridadeController@index');  
        }  
    }
    // function import pdf and excel
    // public function exportarExcel(Request $request)
    // {
        
    //     $data = TipoPrioridade::select('id as Id', 'nome as Nome')->orderBy('id')->get()->toArray();
    //     return \Excel::create('export_tipo_prioridade', function($excel) use ($data) {
    //         $excel->sheet('Plan 1', function($sheet) use ($data)
    //         {
    //             $sheet->fromArray($data);
    //         });
    //     })->download('xlsx');
    // }
}
