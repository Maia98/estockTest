<?php

namespace App\Model\Form;

use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    //
    protected $table    = "form_fields";
    protected $fillable = ['form_id', 'type_id',
                         'label', 'required','private','edit_mask',
                          'name', 'configuration', 'sort', 'hint', 'size'];

    /*public function fields(){
       
               return $this->belongsTo('App\Model\Form\Form');
     }*/                      
}
