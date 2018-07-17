<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TipoApoio extends Model
{
    protected $table    = "tipo_apoio";
    protected $fillable = ['nome', 'descricao'];

    public function rules() { 

        return [ 
            'nome'      => 'required|unique:tipo_apoio,nome'. (($this->id) ? ', ' . $this->id : ''),
            'descricao' => 'required|unique:tipo_apoio,descricao'. (($this->id) ? ', ' . $this->id : '')
        ];
    }
    
    public $msgRules = [
        'nome.unique'        => 'Nome cadastrado.',
        'nome.required'      => 'Nome não preenchido.',
        'descricao.unique'   => 'Descrição cadastrada.',
        'descricao.required' => 'Descrição não preenchida.'
    ];
}