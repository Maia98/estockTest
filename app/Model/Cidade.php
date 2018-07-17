<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    protected $table    = "cidade";
    protected $fillable = ['nome', 'regional_id'];

    public function regional()
    {
      return $this->belongsTo('App\Model\Regional', 'regional_id', 'id');
    }

    public function rules() { 

        return [ 
            'nome'          => 'required|unique:cidade,nome'. (($this->id) ? ', ' . $this->id : ''),
            'regional_id'   =>'required|not_in:0',
            ];
    }
    
    public $msgRules = [
        'nome.unique'           => 'Nome cadastrado.',
        'nome.required'         => 'Nome não preenchido.',
        'regional_id.required'  => 'Regional não preenchida.',
        'regional_id.not_in'    => 'Regional não selecionado.',
    ];
}
