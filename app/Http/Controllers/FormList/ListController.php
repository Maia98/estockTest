<?php

namespace App\Http\Controllers\FormList;

use Dotenv\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Form\Lista;
use App\Http\Requests\ListFormValidationRequest;
use Illuminate\Support\Facades\DB;
class ListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $this->authorize('CONSULTAR_TABELAS_SISTEMA');
        //$filter = $request->input('filtro_input');

        $result = Lista::orderBy('id');

        /*if($filter){
            $filter_like = "%".$filter."%";

            $result = $result->where('nome','ilike', $filter_like)
                ->orWhere('descricao','ilike',$filter_like);
        }*/

        $result = $result->paginate(10);


        return view('pages.list.index', compact('result'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');

        return view('pages.list.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');
        $id = $request->input('id');

        $list = Lista::find($id);

        if (!$list){
            $list = new Lista();
        }

        $list->fill($request->all());

        $validator = validator($request->all(), [
            'name' => 'required',
            'name_plura' => 'required',
            'sort_model' => 'required',
            'notes' => 'max:255|nullable',
        ], [
            'name.required' => 'Nome não preenchido',
            'name_plura.required' => 'Nome Plural não preenchido',
            'sort_model.required' => 'Ordenação não selecionada',
            ]
        );

        if ($validator->fails()) {

            return redirect('/sistema/list')
                ->withErrors($validator)
                ->withInput();
        }else{

            if (isset($list))
             $save = $list->save();
            else
            $create = $list->create($request->all());

            if ($save || $create){
               return  redirect('/sistema/list');
            }else{
               return  redirect('/sistema/list')
                    ->withErrors('ERROR')
                    ->withInput();
            }
        }



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');
        if (Lista::find($id)) {
            $list = Lista::find($id);
        }
        return view('pages.list.form', compact('list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
       // dd($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id, Lista $lista)
    {
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');

        if (Lista::find($id)){
            $list = Lista::find($id);
        }

        $this->authorize('EXCLUIR_TABELAS_SISTEMA');
        return view('pages.list.delete', compact(['list']));

    }


    public function destroy(Request $request)
    {

        $this->authorize('EXCLUIR_TABELAS_SISTEMA');

        $id = $request->input('id');
        $list = Lista::find($id);
        if (!empty($list)){
            try {
                $delete = DB::table('listas')
                    ->where('id', $id)
                    ->delete();
              if ($delete){
                  notify()->flash('Lista excluido com sucesso.', 'success');
              }else{
                  notify()->flash('Erro ao excluir Lista.');
              }
            }catch (\Exception $exc){
                if( $exc->getCode() == 23503) {

                    notify()->flash('Não é permitido excluir Lista em uso.', 'danger');

                }else{

                    notify()->flash('Erro ao excluir Lista.', 'danger');
                }
            }finally {
                return redirect()->action('FormList\ListController@index');
            }
        }
        //return  redirect('/sistema/list');
    }
}
