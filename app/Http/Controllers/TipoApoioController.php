<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\TipoApoio;

class TipoApoioController extends Controller
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

        $result = TipoApoio::orderBy('id');

        if($filter){
            $filter_like = "%".$filter."%";
            
            $result = $result->where('nome','ilike', $filter_like)
                             ->orWhere('descricao','ilike',$filter_like);
        }
        $result = $result->paginate(10);

        return view('pages.tipo-apoio.index', compact('result', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('CADASTRAR_TABELAS_SISTEMA');

        return view('pages.tipo-apoio.form');
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

        $tipoApoio = TipoApoio::find($id);

        if(!$tipoApoio){
            $tipoApoio = new TipoApoio();
        }

        $tipoApoio->fill($request->all());

        $validade = validator($request->all(), $tipoApoio->rules(), $tipoApoio->msgRules);

        if($validade->fails())
        {
            return response()->json(['success' => false, 'msg' => arrayToValidator($validade->getMessageBag())]);
        }

        $save = $tipoApoio->save();
        
        if($save)
        {
            return response()->json(['success' => true, 'msg' => 'Tipo Apoio cadastrado com sucesso.', 'result' => $tipoApoio ]);
        }else{
            return response()->json(['success' => false, 'msg' => 'Erro ao cadastrar Tipo Apoio.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoApoio $tipoApoio)
    {
        $this->authorize('CADASTRAR_TABELAS_SISTEMA');
        return view('pages.tipo-apoio.form', compact('tipoApoio'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(TipoApoio $tipoApoio)
    {
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');
        return view('pages.tipo-apoio.delete', compact('tipoApoio'));
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
            $detete = \DB::table('tipo_apoio')
                           ->where('id', $id)
                           ->delete();

            if($detete)
            {

                notify()->flash('Tipo Apoio excluido com sucesso.', 'success');

            }else{

                notify()->flash('Erro ao excluir Tipo prioridade.');

            }
        } catch (\Exception $exc) {
            if( $exc->getCode() == 23503) {

                notify()->flash('Não é permitido excluir Tipo Apoio em uso.', 'danger');   

            }else{
                
                notify()->flash('Erro ao excluir Tipo Apoio.', 'danger');        
            }
        } finally {
            return redirect()->action('TipoApoioController@index');  
        }  
    }
}
