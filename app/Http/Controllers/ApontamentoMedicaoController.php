<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\ApontamentoMedicao;

class ApontamentoMedicaoController extends Controller
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

        $result = ApontamentoMedicao::orderBy('id');

        if($filter){
            $filter_like = "%".$filter."%";
            
            $result = $result->where('nome','ilike', $filter_like)
                             ->orWhere('descricao','ilike',$filter_like);
        }
        $result = $result->paginate(10);

        return view('pages.apontamento-medicao.index', compact('result', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('CADASTRAR_TABELAS_SISTEMA');

        return view('pages.apontamento-medicao.form');
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

        $apontamentoMedicao = ApontamentoMedicao::find($id);

        if(!$apontamentoMedicao){
            $apontamentoMedicao = new ApontamentoMedicao();
        }

        $apontamentoMedicao->fill($request->all());

        $validate = validator($request->all(), $apontamentoMedicao->rules(), $apontamentoMedicao->msgRules);

        if($validate->fails())
        {
            return response()->json(['success' => false, 'msg' => arrayToValidator($validate->getMessageBag())]);
        }

        $save = $apontamentoMedicao->save();
        
        if($save)
        {
            return response()->json(['success' => true, 'msg' => 'Apontamento de Medição cadastrado com sucesso.', 'result' => $apontamentoMedicao ]);
        }else{
            return response()->json(['success' => false, 'msg' => 'Erro ao cadastrar Apontamento de Medição.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ApontamentoMedicao $apontamentoMedicao)
    {
        $this->authorize('CADASTRAR_TABELAS_SISTEMA');
        return view('pages.apontamento-medicao.form', compact('apontamentoMedicao'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(ApontamentoMedicao $apontamentoMedicao)
    {
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');
        return view('pages.apontamento-medicao.delete', compact('apontamentoMedicao'));
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
            $detete = \DB::table('apontamento_medicao')
                           ->where('id', $id)
                           ->delete();

            if($detete)
            {

                notify()->flash('Apontamento de Medição excluido com sucesso.', 'success');

            }else{

                notify()->flash('Erro ao excluir Apontamento de Medição.');

            }
        } catch (\Exception $exc) {
            if( $exc->getCode() == 23503) {

                notify()->flash('Não é permitido excluir Apontamento de Medição em uso.', 'danger');

            }else{
                
                notify()->flash('Erro ao excluir Apontamento de Medição.', 'danger');
            }
        } finally {
            return redirect()->action('ApontamentoMedicaoController@index');
        }  
    }
}
