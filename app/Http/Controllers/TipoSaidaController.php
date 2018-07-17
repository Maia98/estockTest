<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\TipoSaida;

class TipoSaidaController extends Controller
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

        $result = TipoSaida::orderBy('nome');

        if($filter){
            $filter_like = "%".$filter."%";

            $result = $result->where('nome','ilike', $filter_like);
        }

        $result = $result->paginate(10);

        return view('pages.tipo-saida.index', compact('result', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('CADASTRAR_TABELAS_SISTEMA');

        return view('pages.tipo-saida.form');
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

        $tipoSaida = TipoSaida::find($id);

        if(!$tipoSaida){
            $tipoSaida = new TipoSaida();
        }

        $tipoSaida->fill($request->all());

        $validade = validator($request->all(), $tipoSaida->rules(), $tipoSaida->msgRules);

        if($validade->fails())
        {
            return response()->json(['success' => false, 'msg' => arrayToValidator($validade->getMessageBag())]);
        }

        $save = $tipoSaida->save();
        
        if($save)
        {
            return response()->json(['success' => true, 'msg' => 'Tipo Saída cadastrado com sucesso.', 'result' => $tipoSaida]);
        }else{
            return response()->json(['success' => false, 'msg' => 'Erro ao cadastrar Tipo Saída.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoSaida $tipoSaida)
    {
        $this->authorize('CADASTRAR_TABELAS_SISTEMA');

        return view('pages.tipo-saida.form', compact('tipoSaida'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(TipoSaida $tipoSaida)
    {
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');

        return view('pages.tipo-saida.delete', compact('tipoSaida'));
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
            $detete = \DB::table('tipo_saida')
                           ->where('id', $id)
                           ->delete();

            if($detete)
            {
                
                notify()->flash('Tipo Saída excluido com sucesso.', 'success');

            }else{

                notify()->flash('Erro ao excluir Tipo Saída.', 'danger');

            }
        } catch (\Exception $exc) {
            if( $exc->getCode() == 23503) {

                notify()->flash('Não é permitido excluir Tipo Saída em uso.', 'danger');   

            }else{
                
                notify()->flash('Erro ao excluir Tipo Saída.', 'danger');        
            }
        } finally {
            return redirect()->action('TipoSaidaController@index');  
        }  
    }

}
