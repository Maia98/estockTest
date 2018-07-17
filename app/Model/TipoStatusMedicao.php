<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TipoStatusMedicao extends Model
{
    protected $table    = "tipo_status_medicao";
    protected $fillable = ['nome'];

    public function rules() { 

        return [ 
            'nome' => 'required|unique:tipo_status_medicao,nome'. (($this->id) ? ', ' . $this->id : '')
            ];
    }
    
    public $msgRules = [
        'nome.unique'   => 'Nome cadastrado.',
        'nome.required' => 'Nome não preenchido.',
    ];
}
