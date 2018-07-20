<?php

namespace App\Http\Controllers\FormList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Form\Form;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

       $result = Form::all();

        return view('pages.form.index', compact(['result']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view("pages.form.form", compact(''));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        //dd($request->all());
        
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');
        $id = $request->input('id');

        $form = Form::find($id);
        
        if (!$form){
            $form = new Form();
        }
        
        $form->fill($request->all());
        
        $validator = validator($request->all(), [
            'title' => 'required',
            'notes' => 'max:255|nullable',
        ], [
            'title.required' => 'Título não preenchido',
            ]
        );

        if ($validator->fails()) {
           
            return redirect('/sistema/form')
                ->withErrors($validator)
                ->withInput();
        }else{

            if (isset($form))
             $save = $form->save();
            else
            $create = $form->create($request->all());

            if ($save || $create){
               return  redirect('/sistema/form');
            }else{
               return  redirect('/sistema/form')
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
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');
        //
        if(Form::find($id)){
            $form = Form::find($id);
            return view("pages.form.form", compact('form'));
        }

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
    }

    
    public function delete($id){
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');

        if (Form::find($id)){
            $form = Form::find($id);
        }

        $this->authorize('EXCLUIR_TABELAS_SISTEMA');
        return view('pages.form.delete', compact(['form']));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        /*
        
        $id = $request->input('id');

        $item = ListItem::find($id);

        $alert = "Erro ao excluir item";
        if (isset($item)) {
            $delete = ListItem::destroy($id);

            if ($delete) {
                return redirect()->action('FormList\ItemController@show', compact('id'));
            } else {
                return view('pages.list.formitem', compact('alert'));
            }
        }
        */

        $this->authorize('EXCLUIR_TABELAS_SISTEMA');

        
        
        $id = $request->input('id');
        $result = Form::all();
        $form = Form::find($id);

        if($form->deletable == 1){
            $delete = Form::destroy($id);
            if ($delete) {
                return redirect()->action('FormList\FormController@index');
            } else{
                $alert = "Erro ao excluir Formulário.";
                return redirect()->action('FormList\FormController@index', 'alert', 'result');
            }
        }else {
            $alert = "Formulário não tem permissão para ser excluido.";
            return view('pages.form.index', compact(['alert','result']));
        }

    }
}
