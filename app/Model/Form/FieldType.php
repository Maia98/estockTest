<?php

namespace App\Model\Form;

use Illuminate\Database\Eloquent\Model;

class FieldType extends Model
{
   
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
    protected $table  = "field_types";


    public function fieldform(){
        return hasMany('App\Model\Form\Form');
    }
<<<<<<< HEAD
=======
=======
    protected $table    = "form_fields";
    protected $fillable = ['form_id', 'list_item_id', 'type',
                         'label', 'required','private','edit_mask',
                          'name', 'configuration', 'sort', 'hint'];
>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
}
