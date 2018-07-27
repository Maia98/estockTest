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
>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
use Illuminate\Support\Facades\DB;

class FieldController extends Controller
{
<<<<<<< HEAD
    private $nElem = 10;
=======
>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        
        
        
        return view('pages.form.indexField', compact(['form','list','type', 'fields']));
    }

    public function filter(Request $request)
    {
        
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
<<<<<<< HEAD
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');

        $id = $request->input('id');
        $form_id = $request->input('form_id');
        $field = FormField::find($id);
        
        
        if (!$field) {
            $field = new FormField();
        }

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
        ], [
                'label.required' => 'Rótulo não preenchido.',
                'name.required' => 'Variável não preenchida.',
                'form_id.required' => 'id do formulário não preenchido.',
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
            return redirect('/sistema/form/field/'.$form_id)
                ->withErrors($validator)
                ->withInput();
        } else {

<<<<<<< HEAD
            if (isset($field)){
                
                if(substr($field->type_id,0,5) === 'type-'){
                    $field_type_id = substr($field->type_id, 5); 
                }
                elseif(substr($field->type_id,0,5) === 'list-'){
                    $field_type_id = substr($field->type_id, 5);   
                }
                
                if($field->type_id === 'list-'.$field_type_id ){
            
                    if(Lista::find($field_type_id)){
                        $list = Lista::find($field_type_id); 
                        $itens = ListItem::where('lista_id', $field_type_id)->get();
                        
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
=======
            if (isset($field))
                $save = $field->save();
            else
                $create = $field->create($request->all());

            if ($save || $create) {
>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
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
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');
       
        $field = FormField::find($id);
        //$form = Form::find($id);
        $lists = Lista::all();
        $type = DB::table('field_types')->select('id','desc')->get();
        return view('pages.form.formField', compact(['field', 'lists','type']));
=======
>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
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

    public function delete($id){

        $field = FormField::find($id);

        return view('pages.form.deleteField', compact(['field']));
    }
=======
>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
<<<<<<< HEAD
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
                    $select .= "<option value='".$i->id."'>".$i->value."</option>";
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

=======
    public function destroy($id)
    {
        //
    }
>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
}
