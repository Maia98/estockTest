<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table    = "empresa";
    protected $fillable = [
                            'cnpj', 
                            'razao_social', 
                            'nome_fantasia', 
                            'insc_estadual', 
                            'email', 
                            'cep', 
                            'logradouro', 
                            'numero', 
                            'complemento', 
                            'bairro', 
                            'cidade', 
                            'uf_id' , 
                            'telefone', 
                            'celular',
                            'logo'
                        ];


    public function uf()
    {
      return $this->belongsTo('App\Model\Estados', 'uf_id', 'id');
    }

    public function maskTelefone($telefone)
    {
      return "(".substr($telefone,0,2).") ".substr($telefone,2,4)."-".substr($telefone,6,4);
    }

    public function rules() { 

        return [ 
            'cnpj'                  => 'required|unique:empresa,cnpj'. (($this->id) ? ', ' . $this->id : ''),
            'razao_social'          => 'required', 
        ];
    }
    
    public $msgRules = [
        'cnpj.required'                 => 'CNPJ não preenchido.',
        'cnpj.unique'                   => 'CNPJ já existe.',
        'razao_social.required'         => 'Razão Social não preenchida.',
    ];

}