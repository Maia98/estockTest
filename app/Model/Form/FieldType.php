<?php

namespace App\Model\Form;

use Illuminate\Database\Eloquent\Model;

class FieldType extends Model
{
   
    protected $table    = "form_fields";
    protected $fillable = ['form_id', 'list_item_id', 'type',
                         'label', 'required','private','edit_mask',
                          'name', 'configuration', 'sort', 'hint'];
}
