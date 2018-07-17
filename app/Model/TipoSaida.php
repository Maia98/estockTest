<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TipoSaida extends Model
{
    protected $table    = "tipo_saida";
    protected $fillable = ['nome'];

    public function rules() { 

        return [ 
            'nome' => 'required|unique:tipo_saida,nome'. (($this->id) ? ', ' . $this->id : '')
        ];
    }
    
    public $msgRules = [
        'nome.unique'   => 'Nome cadastrado.',
        'nome.required' => 'Nome não preenchido.',
    ];
}