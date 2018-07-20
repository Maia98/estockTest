<?php

namespace App\Http\Controllers\FormList;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Form\Form;
use App\Model\Form\Lista;
use App\Model\Form\FieldType;
use Illuminate\Support\Facades\DB;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_form)
    {
        //
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');

        //$fields = Form::find($id_form)->fields()->where('form_id',$id_form)->get();
        //PAREI AQUI...
        
        $form = Form::find($id_form);
        $lists = Lista::all();
        $type = FieldType::all();
        
        return view('pages.form.indexField', compact(['form','lists','type']));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');
        
        $form_id = Form::find($id);
        $form = Form::find($id);
        $lists = Lista::all();
        $type = DB::table('field_types')->select('id','desc')->get();
        return view('pages.form.formField', compact(['form_id', 'lists','type']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
       
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');
        $id = $request->input('id');
        $form_id = $request->input('form_id');
        $field = FieldType::find($id);

        if (!$field) {
            $field = new FieldType();
        }

        $field->fill($request->all());
         
        $validator = validator($request->all(), [
            'label' => 'required',
            'name' => 'required',
            'form_id' => 'required',
            'type' => 'required',
            'required' => 'required|numeric',
            'private' =>  'required|numeric',
        ], [
                'label.required' => 'Rótulo não preenchido.',
                'name.required' => 'Variável não preenchida.',
                'form_id.required' => 'id do formulário não preenchido.',
                'required.required' => 'Campo Obrigatório não selecionado.',
                'required.numeric' => 'Valor do campo Obrigatório não é numérico.',
                'private.required' => 'Campo Privado não selecionado.',
                'private.numeric' => 'Valor do campo Privado não é numérico.' 
            ]
        );

        if ($validator->fails()) {

            return redirect('/sistema/form/field/'.$form_id)
                ->withErrors($validator)
                ->withInput();
        } else {

            if (isset($field))
                $save = $field->save();
            else
                $create = $field->create($request->all());

            if ($save || $create) {
                return redirect('/sistema/form/field/'.$form_id);
            } else {
                return redirect('/sistema/form/field/'.$form_id)
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
