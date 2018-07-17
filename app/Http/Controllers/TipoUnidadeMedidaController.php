<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\TipoUnidadeMedida;

class TipoUnidadeMedidaController extends Controller
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

        $result = TipoUnidadeMedida::orderBy('id');

        if($filter){
            $filter_like = "%".$filter."%";
            
            $result = $result->whereRaw('CAST(codigo as TEXT) ILIKE ?',$filter_like)
                             ->orWhere('descricao', 'ilike', $filter_like);
        }

        $result = $result->paginate(10);

        return view('pages.tipo-unidade-medida.index', compact('result','filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('CADASTRAR_TABELAS_SISTEMA');

        return view('pages.tipo-unidade-medida.form');
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

        $id              = $request->input('id');
        $ponto_flutuante = $request->input('ponto_flutuante'); 

        $tipoUnidade = TipoUnidadeMedida::find($id);

        if(!$tipoUnidade){
            $tipoUnidade = new TipoUnidadeMedida();
        }

        $tipoUnidade->fill($request->all());

        if($ponto_flutuante != '1'){
            $tipoUnidade->ponto_flutuante = '0';
        }

        $validade = validator($request->all(), $tipoUnidade->rules(), $tipoUnidade->msgRules);

        if($validade->fails())
        {
            return response()->json(['success' => false, 'msg' => arrayToValidator($validade->getMessageBag())]);
        }

        $save = $tipoUnidade->save();
        
        if($save)
        {
            return response()->json(['success' => true, 'msg' => 'Tipo unidade medida cadastrada com sucesso.', 'result' => $tipoUnidade]);
        }else{
            return response()->json(['success' => false, 'msg' => 'Erro ao cadastrar Tipo unidade.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoUnidadeMedida $tipoUnidade)
    {
        $this->authorize('CADASTRAR_TABELAS_SISTEMA');

        return view('pages.tipo-unidade-medida.form', compact('tipoUnidade'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(TipoUnidadeMedida $tipoUnidade)
    {
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');

        return view('pages.tipo-unidade-medida.delete', compact('tipoUnidade'));
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
            $detete = \DB::table('tipo_unidade_medida')
                           ->where('id', $id)
                           ->delete();

            if($detete)
            {
                notify()->flash('Tipo Unidade Medida excluido com sucesso.', 'success');
            
            }else{
                
                notify()->flash('Erro ao excluir Tipo Unidade Medida.', 'danger');
            }
        } catch (\Exception $exc) {
            if( $exc->getCode() == 23503) {
        
                notify()->flash('Não é possivel excluir Tipo Unidade Medida em uso.', 'danger');
        
            }else{
        
                notify()->flash('Erro ao excluir Tipo Unidade Medida.', 'danger');
            }
        } finally {
            return redirect()->action('TipoUnidadeMedidaController@index');  
        } 
    }
}
