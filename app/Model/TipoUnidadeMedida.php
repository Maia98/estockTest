<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TipoUnidadeMedida extends Model
{
	protected $table    = 'tipo_unidade_medida';
	protected $fillable = ['codigo', 'descricao', 'ponto_flutuante']; 

	public function rules(){
		return [
			'codigo'    => 'required|unique:tipo_unidade_medida,codigo'. (($this->id) ? ', ' . $this->id : ''),
			'descricao' => 'required|max:500|unique:tipo_unidade_medida,descricao'. (($this->id) ? ', ' . $this->id : ''),
			'ponto_flutuante' => 'required'
		];
	}

	public $msgRules = [
		'codigo.required'    => 'Código não preenchido.',
		'codigo.unique'		 => 'Código cadastrado.',
		'descricao.required' => 'Descrição não preenchida.',
		'descricao.max'      => 'Descrição só pode ter no máximo 500 caracteres.',
		'descricao.unique'	 => 'Descrição cadastrada.',
		'ponto_flutuante.required'    => 'Valor decimal não preenchido.'
	];
}
