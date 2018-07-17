<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Almoxarifado;
use App\Model\Cidade;

class AlmoxarifadoController extends Controller
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

        $result = Almoxarifado::orderBy('id');

        if($filter){
            $filter_like = "%".$filter."%";
                  
            $result = $result->where('nome','ilike', $filter_like)
                             ->orWhere('descricao','ilike',$filter_like);                           
        }

        $result = $result->paginate(10);

        return view('pages.almoxarifado.index', compact('result', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('CADASTRAR_TABELAS_SISTEMA');
        $cidades = Cidade::all()->toArray();

        return view('pages.almoxarifado.form', compact('cidades'));
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



        $almoxarifado = Almoxarifado::find($id);

        if(!$almoxarifado){
            $almoxarifado = new Almoxarifado();
        }

        $almoxarifado->fill($request->all());

        $validade = validator($request->all(), $almoxarifado->rules(), $almoxarifado->msgRules);

        if($validade->fails())
        {
            return response()->json(['success' => false, 'msg' => arrayToValidator($validade->getMessageBag())]);
        }
        
        $save = $almoxarifado->save();
        
        if($save)
        {
            return response()->json(['success' => true, 'msg' => 'Almoxarifado cadastrado com sucesso.', 'result' => $almoxarifado ]);
        }else{
            return response()->json(['success' => false, 'msg' => 'Erro ao cadastrar Almoxarifado.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Almoxarifado $almoxarifado)
    {
        $this->authorize('CADASTRAR_TABELAS_SISTEMA');
        $cidades = Cidade::all()->toArray();
        return view('pages.almoxarifado.form', compact('almoxarifado', 'cidades'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Almoxarifado $almoxarifado)
    {
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');
        return view('pages.almoxarifado.delete', compact('almoxarifado'));
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
            $detete = \DB::table('almoxarifado')
                           ->where('id', $id)
                           ->delete();

            if($detete)
            {

                notify()->flash('Almoxarifado excluido com sucesso.', 'success');

            }else{

                notify()->flash('Erro ao excluir Almoxarifado.');

            }
        } catch (\Exception $exc) {
            if( $exc->getCode() == 23503) {

                notify()->flash('Não é permitido excluir Almoxarifado em uso.', 'danger');   

            }else{
                
                notify()->flash('Erro ao excluir Almoxarifado.', 'danger');        
            }
        } finally {
            return redirect()->action('AlmoxarifadoController@index');  
        }  
    }
}
