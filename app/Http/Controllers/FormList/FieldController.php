<?php

namespace App\Http\Controllers\FormList;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Form\Form;
use App\Model\Form\Lista;
use App\Model\Form\FieldType;
<<<<<<< HEAD
use App\Model\Form\FormField;
use App\Model\Form\ListItem;
=======
<<<<<<< HEAD
use App\Model\Form\FormField;
use App\Model\Form\ListItem;
=======
>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
use Illuminate\Support\Facades\DB;

class FieldController extends Controller
{
<<<<<<< HEAD
    private $nElem = 5;
=======
<<<<<<< HEAD
    private $nElem = 10;
=======
>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
<<<<<<< HEAD
    public function index(Request $request, $id_form=null)
    {
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');
        $form = new Form;
        if($id_form != null){
            $form = Form::find($id_form);
            session(['id_form' => $id_form]);
            //return $id_form;
        }else{
            $id_form = $request->session()->get('id_form');
            $form = Form::find($id_form);
        }
        $list = Lista::all();
        $type = FieldType::all();
        $filter = $request->input('filtro_input');
        $fields = new FormField;
        
        if($filter){
            $filter_like = "%".$filter."%";      
            $fields = $form->form_fields()->where('label','ilike', $filter_like)
                             ->orWhere('name','ilike', $filter_like)
                             ->orWhere('type_id', 'ilike', $filter_like)
                             ->paginate($this->nElem);
        }
        else
            $fields = $form->form_fields()->where('form_id', $id_form)->paginate($this->nElem);

=======
<<<<<<< HEAD
    public function index(Request $request, $id_form=null)
    {
        
        //
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');
        $form = Form::find($id_form);
        $list = Lista::all();
        $type = FieldType::all();
        $filter = $request->input('filtro_input');
        //$fields = new FormField;
        
        /* if($filter){
            $filter_like = "%".$filter."%";      
            $fields = $fields->where('label','ilike', $filter_like)
                             ->orWhere('name','ilike', $filter_like)
                             ->orWhere('type_id', 'ilike', $filter_like)
                             ->paginate($this->nElem)->get();
        }
        else*/
        $fields = $form->form_fields()->where('form_id', $id_form)->paginate($this->nElem);
        
        
        
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
        return view('pages.form.indexField', compact(['form','list','type', 'fields']));
    }

    public function filter(Request $request)
    {
<<<<<<< HEAD
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');
        $form = Form::find($id_form);
        $list = Lista::all();
        $type = FieldType::all();
        $filter = $request->input('filtro_input');
        $fields = new FormField;
        
        if($filter){
            $filter_like = "%".$filter."%";      
            $fields = $form->form_fields()->where('label','ilike', $filter_like)
                             ->orWhere('name','ilike', $filter_like)
                             ->orWhere('type_id', 'ilike', $filter_like)
                             ->paginate($this->nElem);
        }
        else
            $fields = $form->form_fields()->where('form_id', $id_form)->paginate($this->nElem);
        
        
        
        return view('pages.form.indexField', compact(['form','list','type', 'fields']));
    }
    
=======
        
        //
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');
        $form = Form::find($request->input('form_id'));
        $list = Lista::all();
        $type = FieldType::all();
        $filter = $request->input('filtro_input');

        /* if($filter){
            $filter_like = "%".$filter."%";      
            $fields = $fields->where('label','ilike', $filter_like)
                             ->orWhere('name','ilike',$filter_like)->paginate($this->nElem);
        }else
            $fields = $form->form_fields()->where('form_id', $id_form)->paginate($this->nElem);
        */
        
        return view('pages.form.indexField', compact(['form','list','type', 'fields']));
    }

    
=======
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

>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
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
<<<<<<< HEAD
        return view('pages.form.formField', compact(['form_id', 'lists','type','form']));
=======
        return view('pages.form.formField', compact(['form_id', 'lists','type']));
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
        //dd($request->all());
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');

        $id = $request->input('id');
        $form_id = $request->input('form_id');
<<<<<<< HEAD
        echo $id. " --- " . $form_id;
        $field = FormField::find($id);
        $fields = FormField::where('form_id', $form_id)->get();
       
        foreach($fields as $f){
            
            if($request->name == strtolower($f->name)){ 
               return redirect('/sistema/form/field/'.$form_id)->with('alert', 'Nome da variavél já existe no banco.');
            }     
        }

    
        
=======
        $field = FormField::find($id);
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
        
        
        if (!$field) {
            $field = new FormField();
        }

<<<<<<< HEAD

        $field->fill($request->all());
        //dd($field);
        $validator = validator($request->all(), [
            'label' => 'required',
            'form_id' => 'required',
            'type_id' => 'required',
            'required' => 'required|numeric',
            'private' =>  'required|numeric',
            'name' => 'required',
=======
        $field->fill($request->all());
        //dd($field);
=======
       
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');
        $id = $request->input('id');
        $form_id = $request->input('form_id');
        $field = FieldType::find($id);

        if (!$field) {
            $field = new FieldType();
        }

        $field->fill($request->all());
         
>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
        $validator = validator($request->all(), [
            'label' => 'required',
            'name' => 'required',
            'form_id' => 'required',
<<<<<<< HEAD
            'type_id' => 'required',
=======
            'type' => 'required',
>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
            'required' => 'required|numeric',
            'private' =>  'required|numeric',
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
        ], [
                'label.required' => 'Rótulo não preenchido.',
                'name.required' => 'Variável não preenchida.',
                'form_id.required' => 'id do formulário não preenchido.',
<<<<<<< HEAD
                'type_id.required' => 'Campo Tipo não selecionado.',
                'required.required' => 'Campo Obrigatório não selecionado.',
                'required.numeric' => 'Valor do campo Obrigatório não é numérico.',
                'private.required' => 'Campo Privado não selecionado.',
                'private.numeric' => 'Valor do campo Privado não é numérico.',
                'name.unique' => 'Váriavel já existe no banco.' 
            ]
        );
    
        if ($validator->fails()) {
=======
<<<<<<< HEAD
                'type_id.required' => 'Campo Tipo não selecionado.',
=======
>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
                'required.required' => 'Campo Obrigatório não selecionado.',
                'required.numeric' => 'Valor do campo Obrigatório não é numérico.',
                'private.required' => 'Campo Privado não selecionado.',
                'private.numeric' => 'Valor do campo Privado não é numérico.' 
            ]
        );

        if ($validator->fails()) {
<<<<<<< HEAD
=======

>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
            return redirect('/sistema/form/field/'.$form_id)
                ->withErrors($validator)
                ->withInput();
        } else {

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
            if (isset($field)){
                
                if(substr($field->type_id,0,5) === 'type-'){
                    $field_type_id = substr($field->type_id, 5); 
                }
                elseif(substr($field->type_id,0,5) === 'list-'){
<<<<<<< HEAD
                    $field_list_id = substr($field->type_id, 5);   
                }
                
                if($field->type_id === 'list-'.$field_list_id ){
            
                    if(Lista::find($field_list_id)){
                        $list = Lista::find($field_list_id); 
                        $itens = ListItem::where('lista_id', $field_list_id)->get();
=======
                    $field_type_id = substr($field->type_id, 5);   
                }
                
                if($field->type_id === 'list-'.$field_type_id ){
            
                    if(Lista::find($field_type_id)){
                        $list = Lista::find($field_type_id); 
                        $itens = ListItem::where('lista_id', $field_type_id)->get();
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
                        
                        //Tipo select
                        if($list->type === 'select'){
                        $confField = "<select name='".$field->name."' "; 
                        $confField .= " class='form-control' id='".$field->name."'";
                        $confField .= ($field->required == 1)?' required >':' >';
                            $confField .= "<option value=''>- Selecione uma opção -</option>";
                            foreach($itens as $i){
                            $confField .= "<option value='".$i->id."'>".$i->value."</option>";
                             }
                         $confField .= "</select>";

                         //Tipo checkbox
                        }elseif($list->type === 'cbox'){
                            $confField = "<div class='form-group'>";
                            foreach($itens as $i) {
                               
                            $confField .= "<div class='checkbox'>
                                    <label >
                                    <input type='checkbox' name='".$field->name."' id='".$field->name."'>";
                                       $confField .= $i->value;
                            $confField .=  "</label>
                                </div>";
                            }    
                            $confField .="</div>";   
                        }
                        //Tipo radiobutton
                        elseif($list->type === 'radiob'){
                            $confField = "<div class='form-group'>";
                            foreach($itens as $i) { 
                            $confField .= "<div class='radio'>
                                    <label >
                                    <input type='radio' name='".$field->name."' id='".$field->name."'>";
                                       $confField .= $i->value;
                            $confField .=  "</label>
                                </div>";
                            }    
                            $confField .="</div>";   
                        }
                         $field->configuration = $confField;
                         
                    }   
                    
                } 
                //Tipos padrão do form utilizando o input
                elseif($field->type_id == 'type-'.$field_type_id ){
            
                    if(FieldType::find($field_type_id)){
                        $type = FieldType::find($field_type_id);
                        if($type->value == 'textarea'){
                            $confField =  "<textarea  name='".$field->name."' 
                         class='form-control' id='".$field->name."' rows='3' ";
                         $confField .= ($field->required == 1)?' required >':' >';
                         $confField .= "</textarea>";
                         $field->configuration = $confField;
                        }else{
                        
                        $confField =  "<input type='".$type->value."' name='".$field->name."' 
                         class='form-control' id='".$field->name."'"; 
                         $confField .= ($field->required == 1)?' required >':' >';
                         $field->configuration = $confField;
                        }
                    }
        
                }else{
                    echo "Error";
                }
            
                $save = $field->save();
           
            }
            /*else{
                echo "chegou aqui create()";
                exit();
                $create = $field->create($request->all())->first();
            }*/
            if ($save /*|| $create*/) {
<<<<<<< HEAD
=======
=======
            if (isset($field))
                $save = $field->save();
            else
                $create = $field->create($request->all());

            if ($save || $create) {
>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
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
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');
       
        $field = FormField::find($id);
        //$form = Form::find($id);
        $lists = Lista::all();
        $type = DB::table('field_types')->select('id','desc')->get();
        return view('pages.form.formField', compact(['field', 'lists','type']));
<<<<<<< HEAD
=======
=======
>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
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

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409

    public function delete($id){

        $field = FormField::find($id);

        return view('pages.form.deleteField', compact(['field']));
    }
<<<<<<< HEAD
=======
=======
>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
    public function destroy(Request $request)
    {
        //
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');
       
        $id = $request->input('id');
        $form_id = $request->input('form_id');
        $lists = Lista::all();
        $form = Form::find($form_id);
        $type = FieldType::all();
        $fields = $form->form_fields()->where('form_id', $form_id)->get();
            $delete = FormField::destroy($id);
            if ($delete) {
                 return redirect()->route('field', ['form_id' => $form_id]);
            } else{
                
                $alert = "Erro ao excluir o Campo.";
                return redirect()->route('field', ['form_id' => $form_id, 'alert' => $alert]);;
            }
        

    }
    

    public function createConfig($id){
        $field = FormField::find($id);
        return view('pages.form.configField', compact(['field']));
    }

    public function storeConfig(Request $request){
        $id = $request->input('id');
        $field = FormField::find($id);

        if(substr($field->type_id,0,5) === 'type-'){
            $field_type_id = substr($field->type_id, 5); 
        }
        elseif(substr($field->type_id,0,5) === 'list-'){
            $field_type_id = substr($field->type_id, 5);   
        }

         $form_id = $field->form_id;
        // $tp_field = FieldType::find();
        if($field->type_id === 'list-'.$field_type_id ){
            
            if(Lista::find($field_type_id)){
                $list = Lista::find($field_type_id); 
                $itens = ListItem::where('lista_id', $field_type_id)->get();
                
                $select = "<select name='".$field->name."' 
                 class='form-control' id='".$field->name."'>";
                    $select .= "<option value=''>- Selecione uma opção -</option>";
                    foreach($itens as $i){
<<<<<<< HEAD
                    $select .= "<option value='".$i->value."'>".$i->value."</option>";
=======
                    $select .= "<option value='".$i->id."'>".$i->value."</option>";
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
                     }
                 $select .= "</select>";
                 
                 $field->configuration = $select;
                 $save = $field->save();
                if($save){
                    return redirect()->route('field', ['form_id' => $form_id]);
                }else{
                    return redirect()->route('field', ['form_id' => $form_id]);
                }
            }   
            
        }
        if($field->type_id == 'type-'.$field_type_id ){
            
            if(FieldType::find($field_type_id)){
                $type = FieldType::find($field_type_id);
                 $field->configuration = "<input type='".$type->value."' name='".$field->name."' 
                 class='form-control' id='".$field->name."'>";
                $save = $field->save();
                if($save){
                    return redirect()->route('field', ['form_id' => $form_id]);
                }else{
                    return redirect()->route('field', ['form_id' => $form_id]);
                }
            }

        }
        else{
            return "Chegou aqui em error ".$id;
            exit();
        }
       
    
    }

<<<<<<< HEAD
=======
=======
    public function destroy($id)
    {
        //
    }
>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
}
