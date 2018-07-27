<?php

namespace App\Model\Form;

use Illuminate\Database\Eloquent\Model;

class Lista extends Model
{
    //

    protected $table    = "listas";
    protected $fillable = ['name', 'name_plura', 'sort_model', 'notes', 'type'];

    public function rules(){
        return [
            'name' => 'required',
            'name_plura' => 'required',
            'sort_model' => 'required',
        ];
    }

    public function msgRules(){
        return [
            'name.required' => 'Nome não preenchido',
            'name_plura.required' => 'Nome Plural não preenchido',
            'sort_model.required' => 'Ordenação não selecionada',
        ];
    }

}
