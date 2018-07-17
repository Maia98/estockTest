<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class EntradaEstoque extends Model
{
    protected $table    = "entrada_estoque";
    protected $fillable = ['obra_id', 'usuario_id', 'almoxarifado_id', 'funcionario_conferente_id', 'tipo_entrada_estoque_id', 'data', 'obs'];

    

    public function obra(){

        return $this->belongsTo('App\Model\Obra', 'obra_id', 'id');
    }

    public function usuario(){

        return $this->belongsTo('App\User', 'usuario_id', 'id');
    }

    public function almoxarifado(){

        return $this->belongsTo('App\Model\Almoxarifado', 'almoxarifado_id', 'id');
    }

    public function conferente(){
        
        return $this->belongsTo('App\Model\Funcionario', 'funcionario_conferente_id', 'id');
    }

    public function tipoEntrada(){
        
        return $this->belongsTo('App\Model\TipoEntrada', 'tipo_entrada_estoque_id', 'id');
    }

    public function rules() {

        return [
            'obra_id'                   => 'required|not_in:0',
            'data'                      => 'required',
            'tipo_entrada_estoque_id'   => 'required|not_in:0',
            'funcionario_conferente_id' => 'required|not_in:0',
            'almoxarifado_id'           => 'required|not_in:0'
        ];
    }

    public $msgRules = [

        'obra_id.required'                   => 'Número Obra não preenchida.',
        'obra_id.not_in'                     => 'Número Obra não selecionada.',
        'data.required'                      => 'Data Recebimento não preenchida.',
        'tipo_entrada_estoque_id.required'   => 'Tipo Entrada não preenchido.',
        'tipo_entrada_estoque_id.not_in'     => 'Tipo Entrada não selecionada.',
        'funcionario_conferente_id.required' => 'Conferente não preenchido.',
        'funcionario_conferente_id.not_in'   => 'Conferente não selecionado.',
        'almoxarifado_id.required'           => 'Almoxarifado não preenchido.',
        'almoxarifado_id.not_in'             => 'Almoxarifado não selecionado.'
    ];

    public function rulesVariasObras() {

        return [
            'data'                      => 'required',
            'tipo_entrada_estoque_id'   => 'required|not_in:0',
            'funcionario_conferente_id' => 'required|not_in:0',
            'almoxarifado_id'           => 'required|not_in:0'
        ];
    }

    public $msgRulesVariasObras = [
        'data.required'                      => 'Data Recebimento não preenchida.',
        'tipo_entrada_estoque_id.required'   => 'Tipo Entrada não preenchido.',
        'tipo_entrada_estoque_id.not_in'     => 'Tipo Entrada não selecionada.',
        'funcionario_conferente_id.required' => 'Conferente não preenchido.',
        'funcionario_conferente_id.not_in'   => 'Conferente não selecionado.',
        'almoxarifado_id.required'           => 'Almoxarifado não preenchido.',
        'almoxarifado_id.not_in'             => 'Almoxarifado não selecionado.'
    ];

    public static function filterEntradaEstoque($request){

        $result = EntradaEstoque::select('id', 'obra_id', 'usuario_id', 'almoxarifado_id', 'funcionario_conferente_id', 'tipo_entrada_estoque_id', 'data', 'obs');
        
        if(!empty($request['numero_obra']))
        {
            $result = $result->where('obra_id', $request['numero_obra']); 
        }

        if(!empty($request['usuario']))
        {
            $result = $result->where('usuario_id', $request['usuario']); 
        }

        if(!empty($request['conferente']))
        {
            $result = $result->where('funcionario_conferente_id', $request['conferente']);
        }

        if(!empty($request['tipo_de_entrada']))
        {
            $result = $result->where('tipo_entrada_estoque_id', $request['tipo_de_entrada']);
        }

        if(!empty($request['almoxarifado']))
        {
            $result = $result->where('almoxarifado_id', $request['almoxarifado']);
        }

        if(!empty($request['data_inicio']) && !empty($request['data_final']))
        {
            $data_inicio = $request['data_inicio']." 00:00:00";
            $data_final  = $request['data_final']." 23:59:59";

            $result = $result->whereBetween('data', [$data_inicio, $data_final]);
        }

        return $result;

    }
}