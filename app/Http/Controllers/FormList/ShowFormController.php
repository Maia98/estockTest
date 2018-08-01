<?php

namespace App\Http\Controllers\FormList;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Form\Form;
use App\Model\Form\FormField;
use App\Model\Form\FieldType;
use App\Model\Form\Lista;
<<<<<<< HEAD
use App\Model\Form\ListItem;
=======
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
use Illuminate\Support\Facades\DB;

class ShowFormController extends Controller
{
<<<<<<< HEAD
    private $nElem = 5;
=======
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
<<<<<<< HEAD
    public function index(Request $request)
    {

        $this->authorize('CONSULTAR_TABELAS_SISTEMA');

        $filter = $request->input('filtro_input');
        if($filter){
            $filter_like = "%".$filter."%"; 
            $form = Form::where('title','ilike', $filter_like)
                          ->orWhere('notes','ilike',$filter_like)
                          ->orWhere('instructions','ilike',$filter_like)
                          ->paginate($this->nElem);
        }else
            $form = Form::paginate($this->nElem); 
        return view('pages.form.showform.index', compact(['form']));
    }

    /*public function showForm($id){
        $form = Form::find($id); 
        return view('pages.form.showform.index', compact(['form']));
    }*/

=======
    public function index()
    {
        //
        $form = Form::all();
        
        
        return view('pages.form.showform.index', compact(['form']));
    }

>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
<<<<<<< HEAD
    public function create($id)
    {

        $this->authorize('CADASTRAR_TABELAS_SISTEMA');

        $form = Form::find($id);
        $id_form = $form->id;
        $formfields = FormField::where('form_id', $id_form)->get();
        
        if(isset($form) && isset($formfields)){

            $statement = 'CREATE TABLE IF NOT EXISTS table'.$form->id.' ( ';
            
            $statement .= " id_".$form->nametable.$id_form." SERIAL CONSTRAINT pk_id_".$form->nametable.$id_form." PRIMARY KEY,";
        
            foreach($formfields as $field){
                if(substr($field->type_id,0,5) === 'type-'){
                    $field_type_id = substr($field->type_id, 5); 
                    $type = FieldType::find($field_type_id);

                    if($type->value === 'text'){
                        $statement .= ' '.$field->name.$id_form.' varchar(500),';   
                    }
                    if($type->value === 'textarea'){
                        $statement .= ' '.$field->name.$id_form.' text,'; 
                    }
                    if($type->value === 'time'){
                        $statement .= ' '.$field->name.$id_form.' time,'; 
                    }
                    if($type->value === 'date'){
                        $statement .= ' '.$field->name.$id_form.' date,'; 
                    }
                    if($type->value === 'datetime'){
                        $statement .= ' '.$field->name.$id_form.' timestamp,'; 
                    }
                    if($type->value === 'file'){
                        $statement .= ' '.$field->name.$id_form.' varchar(500),'; 
                    }
                    if($type->value === 'number'){
                        $statement .= ' '.$field->name.$id_form.$id_form.' int,'; 
                    }
                }
                elseif(substr($field->type_id,0,5) === 'list-'){
                    $field_list_id = substr($field->type_id, 5);
                    $list = Lista::find($field_list_id);
                    $statement .= ' '.$field->name.$id_form.' varchar(500),';
                }
            }
            $statement = substr($statement, 0, strlen($statement)-1);
            
            $statement .= ");";
            
            DB::statement($statement);
        }
        return view("pages.form.showform.form", compact(['form', 'formfields']));
=======
    public function create()
    {
        //
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
<<<<<<< HEAD
        $form_id = $request->form_id;
        //$nameTable = Form::find($form_id);
        $variavel = FormField::select('name')->where('form_id', $form_id)->get();

        $statement = 'INSERT INTO table'.$form_id.' (';
        $field = '';
        foreach($variavel as $v){
            $field .= ' '.$v->name.$form_id.',';
        }
        $field = substr($field, 0, strlen($field)-1);
        $statement .= ') VALUES (';
        
        $values = '';
        $vlr = " ";
        foreach($variavel as $v){
            $values .= "'";
            $values .= $request->input($v->name);
            $values .= "'";
            $values .= ',';
            $vlr .= "?,";
        }
        
        $values = substr($values, 0, strlen($values)-1);
        $vlr = substr($vlr, 0, strlen($vlr)-1);
 
        DB::insert('insert into table'.$form_id.' ('.$field.') values ('.$values.')');
        return redirect('/sistema/showform/');
=======
        //
      
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
<<<<<<< HEAD
        $this->authorize('CADASTRAR_TABELAS_SISTEMA');
        
        $form = Form::find($id);
        $fields = FormField::select('label')->where('form_id', $form->id)->limit(5)->get();
        $fieldVar = FormField::where('form_id', $form->id)->limit(5)->get();
        $data =  DB::select('select * from table'.$form->id);
        $nameColId = 'id_table'.$form->id;
        
        
        return view("pages.form.showform.showData", compact(['fields','data','fieldVar', 'nameColId','form']));
        
=======
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
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
<<<<<<< HEAD
    public function edit($id, $form_id)
    {
        $this->authorize('CADASTRAR_TABELAS_SISTEMA');
        //
        $form = Form::find($form_id);
        $nameTable = $form->nametable.$form->id;
        $formfields = FormField::where('form_id', $form_id)->get();
        $data = DB::select('select * from table'.$form->id.' where id_table'.$form->id.' = '.$id);
        $id_data = $id;   
        
            foreach($formfields as $ff):
                $nameCol = $ff->name.$form->id;
                
                if(substr($ff->type_id,0,5) === 'type-'){
                    $field_type_id = substr($ff->type_id, 5);
                    $input = $ff->configuration;
                    $input = substr($input, 0, strlen($input)-1);
                      foreach($data as $d):
                        $input .= "value='".$d->$nameCol."' >";
                        $ff->configuration = $input;
                      endforeach;
                }
                elseif(substr($ff->type_id,0,5) === 'list-'){
                    $field_list_id = substr($ff->type_id, 5); 
                    $list = Lista::find($field_list_id);
                       //Excluir esse select; e criar outro com os mesmos dados
                        if($list->type === 'select'){
                            $itens =  ListItem::where('lista_id', $field_list_id)->get(); 
                            //PAREI AQUI
                            /*$select = "<select name='".$nameCol."'  class='form-control' id='".$nameCol."' >";
                            
                            /*
                            <select name='Teste2'  class='form-control' id='Teste2' >
                            <option value=''>- Selecione uma opção -</option>
                            <option value='1'>Teste</option>
                            <option value='2'>Suporte</option>
                            <option value='3'>Recurso Humano</option></select>
                            */ 
                             $select  = $ff->configuration;   
                            
                        }
                        
                        $ff->configuration = $select;
                   
                }
            endforeach;  
        //$teste =  $formfields[0]->configuration = $input;
         
        
        return view("pages.form.showform.form", compact(['form', 'formfields', 'data', 'id_data']));
=======
    public function edit($id)
    {
        //
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
<<<<<<< HEAD
    public function update(Request $request)
    {
        //
        $form_id = $request->input('form_id');
        $data_id = $request->input('id');
        $variavel = FormField::select('name')->where('form_id', $form_id)->get();
        
        
        
        $field = '';
        foreach($variavel as $v){

            $field .= " ".strtolower($v->name.$form_id)." = '".$request->input($v->name)."',";
        }
        $field = substr($field, 0, strlen($field)-1);
        
        //  $sql = 'update table'.$form_id.' set '.$field.' where id_table'.$form_id.' = ?'. $data_id;
        //  echo $sql; exit();

            $save = DB::update('update table'.$form_id.' set '.$field.' where id_table'.$form_id.' = ?', [$data_id]);
            
             if($save){
                return redirect('/sistema/showform/show/'.$form_id)->with('success', 'Registro alterodo com sucesso.');
             }else{
                return redirect('/sistema/showform/show/'.$form_id)->with('error', 'Erro ao alterar o registro.');
             }

    }



    public function delete($form_id, $id){
        return "Teste";
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');

        if (Form::find($form_id)){
            $form = Form::find($id);
            $nameTable = 'table'.$form->id;
            $formfields = FormField::where('form_id', $form_id)->get();
            $form = Form::find($id);
            $fields = FormField::select('label')->where('form_id', $form->id)->limit(5)->get();
            $fieldVar = FormField::where('form_id', $form->id)->limit(5)->get();
            $data =  DB::select('select * from '.$form->nametable.$id.'');
            $nameColId = 'id_'.$form->nametable.$form->id;
        }

        
    }
=======
    public function update(Request $request, $id)
    {
        //
    }

>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
<<<<<<< HEAD
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');
=======
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
        //
    }
}
