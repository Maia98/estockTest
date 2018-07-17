<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Obra;

class MaterialOrcado extends Model
{
    protected $table    = "material_orcado";
    protected $fillable = ['numero_obra', 'cod_mat', 'descricao_mat', 'qtd_orc', 'created_at', 'updated_at'];

    public function obra(){

        return $this->belongsTo('App\Model\Obra', 'numero_obra', 'id');
    }

    public function tipoMaterial(){
        
        return $this->belongsTo('App\Model\TipoMaterial', 'cod_mat', 'codigo');
    }

    public static function filterMaterialOrcado($campos){

        $result = Obra::select('obra.id as id','obra.numero_obra','obra.cidade_id','obra.data_recebimento','obra.tipo_status_obra_id',								   'obra.funcionario_supervisor_id', 'material_orcado.cod_mat', 'material_orcado.descricao_mat', 
        					   'material_orcado.qtd_orc', 'material_orcado.created_at')
        					   ->leftJoin('material_orcado', 'material_orcado.obra_id', '=', 'obra.id')
        					   ->where('material_orcado.cod_mat','!=', 0)
        					   ->where('material_orcado.descricao_mat','!=', '');


        if(isset($campos['filter_numero_obra'])){
            $filter = $campos["filter_numero_obra"].'%';
            $result = $result->whereRaw("CAST(obra.numero_obra AS varchar) LIKE '$filter' ");
        }

        if(isset($campos['filter_status_obra']) && $campos['filter_status_obra'] > 0){
            $result = $result->where('obra.tipo_status_obra_id',$campos['filter_status_obra']); 
        }

         if(isset($campos['filter_cidade']) && $campos['filter_cidade'] > 0){
            $result = $result->where('obra.cidade_id',$campos['filter_cidade']); 
        }

        $campoData = (isset($campos['filter_tipo_data']) && $campos['filter_tipo_data'] > 0) ? Obra::tipoData($campos['filter_tipo_data']) : false;

        if($campoData){
            
            $campos['filter_data_inicial']  = $campos['filter_data_inicial']. ' 00:00';
            $campos['filter_data_final']    = $campos['filter_data_final']. ' 23:59';

            $result = $result->whereBetween($campoData, [$campos['filter_data_inicial'], $campos['filter_data_final']]);
        }
        if(isset($campos['filter_regional']) && $campos['filter_regional'] != 0){
            $result = $result->join('cidade as cid', 'cid.id','=','obra.cidade_id')
                             ->join('regional as reg', 'reg.id','=','cid.regional_id')
                             ->where('reg.id',$campos['filter_regional']);
        }

        if(isset($campos['filter_encarregado']) && $campos['filter_encarregado'] != 0){
            $result = $result->join('funcionario_encarregado_has_obra as enc', 'enc.obra_id','=','obra.id')
                             ->where('enc.funcionario_id',$campos['filter_encarregado']);

        }

        return $result;
    }

}