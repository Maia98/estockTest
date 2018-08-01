<?php

namespace App\Model\Form;

use Illuminate\Database\Eloquent\Model;

class FieldType extends Model
{
   
    protected $table  = "field_types";


    public function fieldform(){
        return hasMany('App\Model\Form\Form');
    }
}
