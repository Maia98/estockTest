<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ApontamentoMedicao extends Model
{
    protected $table    = "apontamento_medicao";
    protected $fillable = ['nome', 'descricao'];

    public function rules() { 

        return [ 
            'nome'      => 'required|unique:apontamento_medicao,nome'. (($this->id) ? ', ' . $this->id : '')
        ];
    }
    
    public $msgRules = [
        'nome.unique'        => 'Nome cadastrado.',
        'nome.required'      => 'Nome não preenchido.'
    ];
}