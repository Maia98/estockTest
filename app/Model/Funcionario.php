<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $table    = "funcionarios";
    protected $fillable = ['nome', 'sobrenome', 'cpf', 'supervisor', 'fiscal', 'encarregado', 'conferente'];

    public function rules() { 

        return [ 
            'nome'          => 'required',
            'sobrenome'     => 'required',
            'cpf'           => 'required|numeric|unique:funcionarios,cpf'. (($this->id) ? ', ' . $this->id : '')
        ];
    }
    
    public $msgRules = [
        'nome.required'      => 'Nome não preenchido.',
        'cpf.unique'         => 'CPF cadastrado.',
        'cpf.required'       => 'CPF não preenchido.',
        'cpf.numeric'        => 'CPF só aceita valores numericos.',
        'sobrenome.required' => 'Sobrenome não preenchido.'
    ];


    public function validaFuncao($campos){

        if($campos['supervisor'] == null && $campos['fiscal'] == null && $campos['encarregado'] == null && $campos['conferente'] == null){
            $this->supervisor = false;
            $this->fiscal = false;
            $this->encarregado = false;
            $this->conferente = false;
            return false;
        }

        if($campos['supervisor'] == null){
            $this->supervisor = false;
        }

        if($campos['fiscal'] == null){
            $this->fiscal = false;
        }
        
        if($campos['encarregado'] == null){
            $this->encarregado = false;
        }
        
        if($campos['conferente'] == null){
            $this->conferente = false;
        }

        return false;
    }
}