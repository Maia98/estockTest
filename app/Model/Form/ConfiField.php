<?php

namespace App\Model\Form;

use Illuminate\Database\Eloquent\Model;

class ConfiField extends Model
{
    protected $table    = "confi_fields";
    protected $fillable = ['formfield_id', 'size', 'width', 'placeholder', 'msgvalidate', 'spaceReser', 'helpText'];

    /* public function form_fields(){
        return $this->hasMany(FormField::class);
    } */
}
