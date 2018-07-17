<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Funcionario;

class FuncionarioController extends Controller
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

        $result = Funcionario::orderBy('id');

        if($filter){
            $filter_like = "%".$filter."%";
            
            $result = $result->where('nome','ilike', $filter_like)
                             ->orWhere('sobrenome','ilike',$filter_like)
                             ->orWhere('cpf','like',$filter_like);
        }

        $result = $result->paginate(10);

        return view('pages.funcionario.index', compact('result', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('CADASTRAR_TABELAS_SISTEMA');
        return view('pages.funcionario.form');
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

        $funcionario = Funcionario::find($id);

        $funcao = $request->only(['supervisor','fiscal','encarregado','conferente']);

        if(!$funcionario){
            $funcionario = new Funcionario();
        }

        $funcionario->fill($request->all());

        $validade = validator($request->all(), $funcionario->rules(), $funcionario->msgRules);

        if($validade->fails())
        {
            return response()->json(['success' => false, 'msg' => arrayToValidator($validade->getMessageBag())]);
        }
        
        if($funcionario->validaFuncao($funcao)){
            return response()->json(['success' => false, 'msg' => 'Função não selecionada']);
        }
       
        
        $save = $funcionario->save();
        
        if($save)
        {
            return response()->json(['success' => true, 'msg' => 'Funcionário cadastrado com sucesso.','result' => $funcionario]);
        }else{
            return response()->json(['success' => false, 'msg' => 'Erro ao cadastrar Funcionário.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Funcionario $funcionario)
    {
        $this->authorize('CADASTRAR_TABELAS_SISTEMA');
        return view('pages.funcionario.form', compact('funcionario'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Funcionario $funcionario)
    {
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');
        return view('pages.funcionario.delete', compact('funcionario'));
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
            $detete = \DB::table('funcionarios')->where('id', $id)->delete();

            if($detete)
            {

                notify()->flash('Funcionário excluido com sucesso.', 'success');

            }else{

                notify()->flash('Erro ao excluir Funcionário.', 'danger');

            }
        } catch (\Exception $exc) {
            if( $exc->getCode() == 23503) {

                notify()->flash('Não é permitido excluir Funcionário em uso.', 'danger');   

            }else{
                
                notify()->flash('Erro ao excluir Funcionário.', 'danger');        
            }
        } finally {
            return redirect()->action('FuncionarioController@index');  
        }  
    }
}
