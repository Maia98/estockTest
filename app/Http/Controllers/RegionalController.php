<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Regional;

class RegionalController extends Controller
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

        $result = Regional::orderBy('id');

        if($filter){
            $filter_like = "%".$filter."%";
            
            $result = $result->where('descricao','ilike',$filter_like);
        }

        $result = $result->paginate(10);
                                    
        return view('pages.regional.index', compact('result', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('CADASTRAR_TABELAS_SISTEMA');
       return view('pages.regional.form');
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

        $regional = Regional::find($id);

        if(!$regional){
            $regional = new Regional();
        }

        $regional->fill($request->all());

        $validade = validator($request->all(), $regional->rules(), $regional->msgRules);

        if($validade->fails())
        {
            return response()->json(['success' => false, 'msg' => arrayToValidator($validade->getMessageBag())]);
        }

        $save = $regional->save();
        
        if($save)
        {
            return response()->json(['success' => true, 'msg' => 'Regional cadastrada com sucesso.', 'result' => $regional]);
        }else{
            return response()->json(['success' => false, 'msg' => 'Erro ao cadastrar  Regional.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Regional $regional)
    {
        $this->authorize('CADASTRAR_TABELAS_SISTEMA');
        return view('pages.regional.form', compact('regional'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function delete(Regional $regional)
    {
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');
        return view('pages.regional.delete', compact('regional'));
    }



    public function destroy(Request $request)
    {
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');
        $id = $request->input('id');

        try {
            $detete = \DB::table('regional')
                           ->where('id', $id)
                           ->delete();

            if($detete)
            {
                notify()->flash('Regional excluida com sucesso.', 'success');

            }else{

                notify()->flash('Erro ao excluir Regional.', 'danger');

            }
        } catch (\Exception $exc) {
            if( $exc->getCode() == 23503) {

                notify()->flash('Não é possivel excluir Regional em uso.', 'danger');

            }else{

                notify()->flash('Erro ao excluir Regional.', 'danger');
                
            }
        } finally {
            return redirect()->action('RegionalController@index');  
        }  
    }
}
