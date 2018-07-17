<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Cidade;
use App\Model\Regional;

class CidadeController extends Controller
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

        $result = Cidade::orderBy('nome');

        if($filter){
            $filter_like = "%".$filter."%";
            
            $result = $result->join('regional as reg', 'reg.id','=','cidade.regional_id')
                             ->where('cidade.nome','ilike', $filter_like)
                             ->orWhere('reg.descricao', 'ilike', $filter_like);
        }

        $result = $result->paginate(10);

        return view('pages.cidade.index', compact('result', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('CADASTRAR_TABELAS_SISTEMA');
        $regional = Regional::all()->toArray();

        return view('pages.cidade.form', compact('regional'));
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

        $cidade = Cidade::find($id);

        if(!$cidade){
            $cidade = new Cidade();
        }

        $cidade->fill($request->all());

        $validade = validator($request->all(), $cidade->rules(), $cidade->msgRules);

        if($validade->fails())
        {
            return response()->json(['success' => false, 'msg' => arrayToValidator($validade->getMessageBag())]);
        }

        $save = $cidade->save();
        
        if($save)
        {
            return response()->json(['success' => true, 'msg' => 'Cidade cadastrada com sucesso.', 'result' => $cidade]);
        }else{
            return response()->json(['success' => false, 'msg' => 'Erro ao cadastrar Cidade.']);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Cidade $cidade)
    {
        $this->authorize('CADASTRAR_TABELAS_SISTEMA');
        $regional = Regional::all()
                                      ->toArray();

        return view('pages.cidade.form', compact('regional', 'cidade'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Cidade $cidade)
    {
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');

        return view('pages.cidade.delete', compact('cidade'));
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
            $detete = \DB::table('cidade')
                           ->where('id', $id)
                           ->delete();

            if($detete)
            {
                notify()->flash('Cidade excluida com sucesso.', 'success');
            
            }else{
                
                notify()->flash('Erro ao excluir Cidade.', 'danger');
            }
        } catch (\Exception $exc) {
            if( $exc->getCode() == 23503) {
        
                notify()->flash('Não é possivel excluir Cidade em uso.', 'danger');
        
            }else{
        
                notify()->flash('Erro ao excluir Cidade.', 'danger');
            }
        } finally {
            return redirect()->action('CidadeController@index');  
        }  
    }

    public function getCidade(Request $request){

        $regionalId = $request->input('regional_id');
        $result = Cidade::select('id','nome');
        
        if($regionalId > 0){
            $result = $result->where('regional_id', $regionalId);
        }

        $result = $result->get()->toArray();
        
        return response()->json($result); 
    }
}
