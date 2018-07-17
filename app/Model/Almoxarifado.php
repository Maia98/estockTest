<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Almoxarifado extends Model
{
    protected $table    = "almoxarifado";
    protected $fillable = ['nome', 'cidade_id', 'descricao'];

    public function cidade()
    {
      return $this->belongsTo('App\Model\Cidade', 'cidade_id', 'id');
    }

    public function rules() { 

        return [ 
            'nome'        => 'required|unique:almoxarifado,nome'. (($this->id) ? ', ' . $this->id : ''),
            'cidade_id'   => 'required|not_in:0',
        ];
    }
    
    public $msgRules = [
        'nome.required'            => 'Nome não preenchido.',
        'nome.unique'              => 'Nome cadastrado.',
        'cidade_id.required'       => 'Cidade não preenchida',
        'cidade_id.not_in'         => 'Cidade não selecionada'
    ];
}