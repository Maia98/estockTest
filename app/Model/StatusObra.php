<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StatusObra extends Model
{
    protected $table    = "status_obra";
    protected $fillable = ['nome','descricao'];

    public function rules() { 

        return [ 
            'nome'      => 'required|unique:status_obra,nome'. (($this->id) ? ', ' . $this->id : ''),
            'descricao' => 'required|unique:status_obra,descricao'. (($this->id) ? ', ' . $this->id : ''),
        ];
    }
    
    public $msgRules = [
        'nome.unique'           => 'Nome cadastrado.',
        'nome.required'         => 'Nome não preenchido.',
        'descricao.unique'      => 'Descrição cadastrada.',
        'descricao.required'    => 'Descrição não preenchida.',
    ];
}
