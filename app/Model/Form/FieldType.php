<?php

namespace App\Model\Form;

use Illuminate\Database\Eloquent\Model;

class FieldType extends Model
{
   
<<<<<<< HEAD
    protected $table  = "field_types";


    public function fieldform(){
        return hasMany('App\Model\Form\Form');
    }
=======
    protected $table    = "form_fields";
    protected $fillable = ['form_id', 'list_item_id', 'type',
                         'label', 'required','private','edit_mask',
                          'name', 'configuration', 'sort', 'hint'];
>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
}
