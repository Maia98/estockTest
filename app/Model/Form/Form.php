<?php

namespace App\Model\Form;

use Illuminate\Database\Eloquent\Model;
use App\Model\Form\FormField;
class Form extends Model
{
    //

    protected $table    = "forms";
<<<<<<< HEAD
    protected $fillable = ['type', 'deletable', 'title', 'instructions', 'notes', 'nametable'];
=======
    protected $fillable = ['type', 'deletable', 'title', 'instructions', 'notes'];
>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007

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

<<<<<<< HEAD
    public function form_fields(){
        return $this->hasMany(FormField::class);
    }     
=======
    /*public function fields(){
        return $this->hasMany('App\Model\Form\FormField');
    }*/
>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
}
