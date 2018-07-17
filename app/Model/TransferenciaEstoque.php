<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TransferenciaEstoque extends Model
{
    protected $table    = "transferencia_estoque";
    protected $fillable = ['almoxarifado_origem_id', 'almoxarifado_destino_id', 'obra_destino_id', 'data', 'usuario_id', 'obs'];

    public function obraDestino(){

        return $this->belongsTo('App\Model\Obra', 'obra_destino_id', 'id');
    }

    public function almoxarifadoDestino(){

        return $this->belongsTo('App\Model\Almoxarifado', 'almoxarifado_destino_id', 'id');
    }

    public function usuario(){

        return $this->belongsTo('App\User', 'usuario_id', 'id');
    }

    public function almoxarifadoOrigem(){

        return $this->belongsTo('App\Model\Almoxarifado', 'almoxarifado_origem_id', 'id');
    }



    public function rules() {

        return [
            'almoxarifado_origem_id'    => 'required | not_in:0',
            'almoxarifado_destino_id'   => 'required | not_in:0',
            'obra_destino_id'           => 'required | not_in:0',
            'data'                      => 'required'
        ];
    }

    public $msgRules = [

        'almoxarifado_origem_id.required'   => 'Almoxarifado de Origem não preenchido.',
        'almoxarifado_origem_id.not_in'     => 'Almoxarifado de Origem não selecionado.',
        'almoxarifado_destino_id.required'  => 'Almoxarifado de Destino não preenchido.',
        'almoxarifado_destino_id.not_in'    => 'Almoxarifado de Destino não selecionado.',
        'obra_destino_id.required'          => 'Obra de Destino não preenchido.',
        'obra_destino_id.not_in'            => 'Obra de Destino não selecionado.',
        'data.required'                     => 'Data Transferencia não preenchida.'
    ];

    public static function filterTransferenciaEstoque($request){
        $result = TransferenciaEstoque::select('transferencia_estoque.id as id','transferencia_estoque.almoxarifado_origem_id as almoxarifado_origem_id'
            ,'transferencia_estoque.almoxarifado_destino_id as almoxarifado_destino_id','transferencia_estoque.obra_destino_id as obra_destino_id'
            ,'transferencia_estoque.data as data','transferencia_estoque.usuario_id as usuario_id', 'obra.numero_obra', 'almoxarifado.nome as almoxarifado_destino_nome', 'users.name')
                                        ->join('transferencia_material_estoque as tme','tme.transferencia_estoque_id', '=','transferencia_estoque.id')
                                        ->join('obra', 'transferencia_estoque.obra_destino_id', '=', 'obra.id')
                                        ->join('almoxarifado', 'transferencia_estoque.almoxarifado_destino_id', '=', 'almoxarifado.id')
                                        ->join('users', 'transferencia_estoque.usuario_id', '=', 'users.id')
                                        ->distinct();
        if(!empty($request['almoxarifado_origem'])){
            $result = $result->where('transferencia_estoque.almoxarifado_origem_id',$request['almoxarifado_origem']);
        }

        if(!empty($request['almoxarifado_destino'])){
            $result = $result->where('transferencia_estoque.almoxarifado_destino_id',$request['almoxarifado_destino']);
        }

        if(!empty($request['obra_destino'])){
            $result = $result->where('transferencia_estoque.obra_destino_id',$request['obra_destino']);
        }

        if(!empty($request['obra_origem'])){
            $result = $result->where('tme.obra_origem_id',$request['obra_origem']);
        }

        if(!empty($request['usuario'])){
            $result = $result->where('transferencia_estoque.usuario_id',$request['usuario']);
        }

        if(isset($request['data_inicio']) && isset($request['data_final']))
        {
            $result = $result->whereBetween('transferencia_estoque.data', [$request['data_inicio'],$request['data_final']]);
        }

        return $result->orderBy('transferencia_estoque.data','desc');

    }
}
