<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\TipoEntrada;

class TipoEntradaController extends Controller
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

        $result = TipoEntrada::orderBy('nome');

        if($filter){
            $filter_like = "%".$filter."%";

            $result = $result->where('nome','ilike', $filter_like);
        }
        
        $result = $result->paginate(10);

        return view('pages.tipo-entrada.index', compact('result', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('CADASTRAR_TABELAS_SISTEMA');
        return view('pages.tipo-entrada.form');
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

        $tipoEntrada = TipoEntrada::find($id);

        if(!$tipoEntrada){
            $tipoEntrada = new TipoEntrada();
        }

        $tipoEntrada->fill($request->all());

        $validade = validator($request->all(), $tipoEntrada->rules(), $tipoEntrada->msgRules);

        if($validade->fails())
        {
            return response()->json(['success' => false, 'msg' => arrayToValidator($validade->getMessageBag())]);
        }

        $save = $tipoEntrada->save();
        
        if($save)
        {
            return response()->json(['success' => true, 'msg' => 'Tipo Entrada cadastrado com sucesso.', 'result' => $tipoEntrada]);
        }else{
            return response()->json(['success' => false, 'msg' => 'Erro ao cadastrar Tipo Entrada.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoEntrada $tipoEntrada)
    {
        $this->authorize('CADASTRAR_TABELAS_SISTEMA');
        return view('pages.tipo-entrada.form', compact('tipoEntrada'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(TipoEntrada $tipoEntrada)
    {
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');
        return view('pages.tipo-entrada.delete', compact('tipoEntrada'));
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
            $detete = \DB::table('tipo_entrada')
                           ->where('id', $id)
                           ->delete();

            if($detete)
            {

                notify()->flash('Tipo Entrada excluido com sucesso.', 'success');

            }else{

                notify()->flash('Erro ao excluir Tipo Entrada.');

            }
        } catch (\Exception $exc) {
            if( $exc->getCode() == 23503) {

                notify()->flash('Não é permitido excluir Tipo Entrada em uso.', 'danger');   

            }else{
                
                notify()->flash('Erro ao excluir Tipo Entrada.', 'danger');        
            }
        } finally {
            return redirect()->action('TipoEntradaController@index');  
        }  
    }

}
