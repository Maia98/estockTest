<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TipoMaterial extends Model
{
    protected $table    = "tipo_material";
    protected $fillable = ['codigo', 'descricao', 'tipo_unidade_medida_material_id', 'constante_material', 'valor_material', 'qtde_minima', 'qtde_critica'];

    
    public function unidade()
    {
      return $this->belongsTo('App\Model\TipoUnidadeMedida', 'tipo_unidade_medida_material_id', 'id');
    }


    public function rules() { 

        return [ 
            'codigo'                                 => 'required|numeric|unique:tipo_material,codigo'. (($this->id) ? ', ' . $this->id : ''), 
            'descricao'                              => 'required',
            'tipo_unidade_medida_material_id'        => 'required|numeric|not_in:0',
            'constante_material'                          => 'nullable',
            'valor_material'                         => 'nullable',
            // 'valor_material'                         => 'nullable|numeric',
            'qtde_minima'                            => 'numeric|nullable',
            'qtde_critica'                           => 'numeric|nullable',
        ];
    }
    
    public $msgRules = [
        'codigo.required'                               => 'Código não preenchido.',
        'codigo.unique'                                 => 'Código cadastrado.',
        'codigo.numeric'                                => 'Código só aceita valores numéricos.',
        'descricao.required'                            => 'Descrição não preenchida.',
        'tipo_unidade_medida_material_id.required'      => 'Unidade não preenchida.',
        'tipo_unidade_medida_material_id.numeric'       => 'Unidade Medida só aceita valores numéricos.',
        'tipo_unidade_medida_material_id.not_in'        => 'Unidade Medida não selecionada.',
        // 'constante_material.numeric'                         => 'Peso só aceita valores numéricos.',
        // 'valor_material.numeric'                        => 'Valor só aceita valores numéricos.',
        'qtde_minima.numeric'                           => 'Qtde. Mínima só aceita valores numéricos.',
        'qtde_critica.numeric'                          => 'Qtde. Critica só aceita valores numéricos.',
    ];
}