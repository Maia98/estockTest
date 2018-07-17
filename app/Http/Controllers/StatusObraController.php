<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\StatusObra;

class StatusObraController extends Controller
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

        $result = StatusObra::orderBy('id');

        if($filter){
            $filter_like = "%".$filter."%";
            
            $result = $result->where('nome','ilike', $filter_like)
                             ->orWhere('descricao','ilike',$filter_like);
        }
        $result = $result->paginate(10);

        return view('pages.status-obra.index', compact('result', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('CADASTRAR_TABELAS_SISTEMA');
        return view('pages.status-obra.form');
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

        $statusObra = StatusObra::find($id);

        if(!$statusObra){
            $statusObra = new StatusObra();
        }

        $statusObra->fill($request->all());

        $validade = validator($request->all(), $statusObra->rules(), $statusObra->msgRules);

        if($validade->fails())
        {
            return response()->json(['success' => false, 'msg' => arrayToValidator($validade->getMessageBag())]);
        }

        $save = $statusObra->save();
        
        if($save)
        {
            return response()->json(['success' => true, 'msg' => 'Status Obra cadastrado com sucesso.', 'result' => $statusObra]);
        }else{
            return response()->json(['success' => false, 'msg' => 'Erro ao cadastrar Status Obra.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(StatusObra $statusObra)
    {
        $this->authorize('CADASTRAR_TABELAS_SISTEMA');
        return view('pages.status-obra.form', compact('statusObra'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(StatusObra $statusObra)
    {
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');
        return view('pages.status-obra.delete', compact('statusObra'));
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
            $detete = \DB::table('status_obra')
                           ->where('id', $id)
                           ->delete();

            if($detete)
            {

                notify()->flash('Status Obra excluido com sucesso.', 'success');

            }else{

                notify()->flash('Erro ao excluir Status Obra.', 'danger');

            }
        } catch (\Exception $exc) {
            if( $exc->getCode() == 23503) {

                notify()->flash('Não é permitido excluir Status Obra em uso.', 'danger');   

            }else{
                
                notify()->flash('Erro ao excluir Status Obra.', 'danger');        
            }
        } finally {
            return redirect()->action('StatusObraController@index');  
        }  
    }
}
