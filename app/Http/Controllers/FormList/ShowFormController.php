<?php

namespace App\Http\Controllers\FormList;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Form\Form;
use App\Model\Form\FormField;
use App\Model\Form\FieldType;
use App\Model\Form\Lista;
use Illuminate\Support\Facades\DB;

class ShowFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $form = Form::all();
        
        
        return view('pages.form.showform.index', compact(['form']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $form = Form::find($id);
        $id_form = $form->id;
        $formfields = FormField::where('form_id', $id_form)->get();
        
        if(isset($form) && isset($formfields)){

        $statement = 'CREATE TABLE IF NOT EXISTS '.$form->nametable.' ( ';
           
        $statement .= " id_".$form->nametable." integer CONSTRAINT pk_id_".$form->nametable." PRIMARY KEY, ";
       
         foreach($formfields as $field){
       
            if(substr($field->type_id,0,5) === 'type-'){
            $field_type_id = substr($field->type_id, 5); 
            $type = FieldType::find($field_type_id);

            if($type->value === 'text'){
                $statement .= ' '.$field->name.' varchar(500), ';   
            }
            if($type->value === 'textarea'){
                $statement .= ' '.$field->name.' text, '; 
            }
            if($type->value === 'time'){
                $statement .= ' '.$field->name.' time, '; 
            }
            if($type->value === 'date'){
                $statement .= ' '.$field->name.' date, '; 
            }
            if($type->value === 'datetime'){
                $statement .= ' '.$field->name.' timestamp, '; 
            }
            if($type->value === 'file'){
                $statement .= ' '.$field->name.' varchar(500), '; 
            }
            if($type->value === 'number'){
                $statement .= ' '.$field->name.' int, '; 
            }

        }
        elseif(substr($field->type_id,0,5) === 'list-'){
            $field_list_id = substr($field->type_id, 5);
            $list = Lista::find($field_list_id);
            $statement .= ' '.$field->name.' varchar(500), ';
        }
        }
        $statement .= ");";

        
        DB::statement($statement);
        
        }
        
        return view("pages.form.showform.form", compact(['form', 'formfields']));
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
