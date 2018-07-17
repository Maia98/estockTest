<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TipoEntrada extends Model
{
    protected $table    = "tipo_entrada";
    protected $fillable = ['nome'];

    public function rules() { 

        return [ 
            'nome' => 'required|unique:tipo_entrada,nome'. (($this->id) ? ', ' . $this->id : '')
        ];
    }
    
    public $msgRules = [
        'nome.unique'   => 'Nome cadastrado.',
        'nome.required' => 'Nome não preenchido.',
    ];
}