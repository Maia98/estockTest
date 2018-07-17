<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\TipoMaterial;
use App\Model\TipoUnidadeMedida;

class TipoMaterialController extends Controller
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

        $result = TipoMaterial::orderBy('id');
        
        if($filter){
            $filter_cod = '%'.preg_replace("/[^0-9]/", "", $filter).'%';
            if($filter_cod == '%%'){
                $filter_cod = null;
            }

            $filter_des = "%".$filter."%";
            
            $result = $result->whereRaw("CAST(codigo AS VARCHAR(9)) LIKE '$filter_cod'")
                             ->orWhere('descricao','like', $filter_des);

    
        }

        $result = $result->paginate(10);

        return view('pages.tipo-material.index', compact('result', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('CADASTRAR_TABELAS_SISTEMA');
        $tipoUnidade = TipoUnidadeMedida::all()->toArray();

        return view('pages.tipo-material.form', compact('tipoUnidade'));
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

        $id    = $request->input('id');
        $valor = $request->input('valor_material');
        $peso  = $request->input('constante_material');

        $valor = str_replace(" ", "", strtr($valor, '.,',' .'));
        $peso  = str_replace(" ", "", strtr($peso, '.,',' .'));

        $tipoMaterial = TipoMaterial::find($id);

        if(!$tipoMaterial){
            $tipoMaterial = new TipoMaterial();
        }

        $tipoMaterial->fill($request->all());

        $validade = validator($request->all(), $tipoMaterial->rules(), $tipoMaterial->msgRules);

        if($validade->fails())
        {
            return response()->json(['success' => false, 'msg' => arrayToValidator($validade->getMessageBag())]);
        }
        
        $tipoMaterial->valor_material = ($valor != 0.00 || $valor != '') ? $valor : null;
        $tipoMaterial->constante_material  = ($peso != 0.00 || $peso != '') ? $peso : null;
        $save = $tipoMaterial->save();

        if($save)
        {
            return response()->json(['success' => true, 'msg' => 'Tipo Material cadastrado com sucesso.', 'result' => $tipoMaterial]);
        }else{
            return response()->json(['success' => false, 'msg' => 'Erro ao cadastrar Tipo Material.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoMaterial $tipoMaterial)
    {
        $this->authorize('CADASTRAR_TABELAS_SISTEMA');

        $tipoUnidade = TipoUnidadeMedida::all()->toArray();

        $tipoMaterial->valor_material = number_format($tipoMaterial->valor_material,2,",",".");

        return view('pages.tipo-material.form', compact('tipoMaterial', 'tipoUnidade'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(TipoMaterial $tipoMaterial)
    {
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');
        return view('pages.tipo-material.delete', compact('tipoMaterial'));
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
            
            $detete = \DB::table('tipo_material')
                           ->where('id', $id)
                           ->delete();

            if($detete)
            {
                notify()->flash('Tipo Material excluido com sucesso.', 'success');

            }else{
                notify()->flash('Erro ao excluir Tipo Material.');
            }

        } catch (\Exception $exc) {
            if( $exc->getCode() == 23503)
            {
                notify()->flash('Não é permitido excluir Tipo Material em uso.', 'danger');   

            }else{   
                notify()->flash('Erro ao excluir Tipo Material.', 'danger');        
            }
        } finally {
            return redirect()->action('TipoMaterialController@index');  
        }  
    }
}