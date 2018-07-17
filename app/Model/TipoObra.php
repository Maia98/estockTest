<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TipoObra extends Model
{
    protected $table    = "tipo_obra";
    protected $fillable = ['descricao'];

    public function rules() { 

        return [ 
            'descricao' => 'required|unique:tipo_obra,descricao'. (($this->id) ? ', ' . $this->id : '')
            ];
    }
    
    public $msgRules = [
        'descricao.unique'   => 'Descrição cadastrada.',
        'descricao.required' => 'Descrição não preenchida.',
    ];
}