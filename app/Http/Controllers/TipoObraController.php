<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\TipoObra;

class TipoObraController extends Controller
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

        $result = TipoObra::orderBy('id');

        if($filter){
            $filter_like = "%".$filter."%";
            
            $result = $result->where('descricao','ilike', $filter_like);
        }
        
        $result = $result->paginate(10);

        return view('pages.tipo-obra.index', compact('result', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('CADASTRAR_TABELAS_SISTEMA');

        return view('pages.tipo-obra.form');
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

        $tipoObra = TipoObra::find($id);

        if(!$tipoObra){
            $tipoObra = new TipoObra();
        }

        $tipoObra->fill($request->all());

        $validade = validator($request->all(), $tipoObra->rules(), $tipoObra->msgRules);

        if($validade->fails())
        {
            return response()->json(['success' => false, 'msg' => arrayToValidator($validade->getMessageBag())]);
        }

        $save = $tipoObra->save();
        
        if($save)
        {
            return response()->json(['success' => true, 'msg' => 'Tipo Obra cadastrado com sucesso.', 'result' => $tipoObra]);
        }else{
            return response()->json(['success' => false, 'msg' => 'Erro ao cadastrar Tipo Obra.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoObra $tipoObra)
    {
        $this->authorize('CADASTRAR_TABELAS_SISTEMA');

        return view('pages.tipo-obra.form', compact('tipoObra'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(TipoObra $tipoObra)
    {
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');

        return view('pages.tipo-obra.delete', compact('tipoObra'));
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
            $detete = \DB::table('tipo_obra')
                           ->where('id', $id)
                           ->delete();

            if($detete)
            {

                notify()->flash('Tipo Obra excluido com sucesso.', 'success');

            }else{

                notify()->flash('Erro ao excluir Tipo Obra.');

            }
        } catch (\Exception $exc) {
            if( $exc->getCode() == 23503) {

                notify()->flash('Não é permitido excluir Tipo Obra em uso.', 'danger');   

            }else{
                
                notify()->flash('Erro ao excluir Tipo Obra.', 'danger');        
            }
        } finally {
            return redirect()->action('TipoObraController@index');  
        }  
    }

}
