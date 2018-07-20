<?php

namespace App\Model\Form;

use Illuminate\Database\Eloquent\Model;
use App\Model\Form\FormField;
class Form extends Model
{
    //

    protected $table    = "forms";
    protected $fillable = ['type', 'deletable', 'title', 'instructions', 'notes'];

    public function rules(){
        return [
            'title' => 'required',
        ];
    }

    public function msgRules(){
        return [
            'title.required' => 'Título não preenchido',
        ];
    }

    /*public function fields(){
        return $this->hasMany('App\Model\Form\FormField');
    }*/
}
