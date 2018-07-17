<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TipoPrioridade extends Model
{
    protected $table    = "tipo_prioridade";
    protected $fillable = ['nome'];

    public function rules() { 

        return [ 
            'nome' => 'required|unique:tipo_prioridade,nome'. (($this->id) ? ', ' . $this->id : '')
        ];
    }
    
    public $msgRules = [
        'nome.unique'   => 'Nome cadastrado.',
        'nome.required' => 'Nome não preenchida.',
    ];
}