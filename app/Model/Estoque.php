<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\StatusObra;
use App\Model\EntradaEstoque;

class Estoque extends Model
{
    protected $table    = "estoque";
    protected $fillable = ['almoxarifado_id', 'tipo_material_id','obra_id', 'qtde'];


    public function almoxarifado()
    {
      return $this->belongsTo('App\Model\Almoxarifado', 'almoxarifado_id', 'id');
    }

    public function material()
    {
      return $this->belongsTo('App\Model\TipoMaterial', 'tipo_material_id', 'id');
    }

    public function tipoMaterial(){
        
        return $this->belongsTo('App\Model\TipoMaterial', 'tipo_material_id', 'id');
    }

    public function obra(){

        return $this->belongsTo('App\Model\Obra', 'obra_id', 'id');
    }

    public function statusObra($status){
        $status_obra = StatusObra::find($status);
        return $status_obra->nome;
    }

    public function dataMovimento($idObra){
        $data_movimento = EntradaEstoque::where('obra_id', $idObra)->first();
        return date('d/m/Y', strtotime($data_movimento->data));
    }

    public function rules() { 

        return [];
    }
    
    public $msgRules = [];

    public static function getEstoqueAll($material = null, $regional = null, $almoxarifado = null, $numero_obra = null)
    {
        $estoque = Estoque::join('tipo_material as mat', 'mat.id', '=', 'estoque.tipo_material_id')
                            ->join('tipo_unidade_medida as unidade', 'unidade.id', '=', 'mat.tipo_unidade_medida_material_id')
                            ->join('almoxarifado as alm', 'alm.id', '=', 'estoque.almoxarifado_id')
                            ->select('mat.id as id','mat.codigo as codigo', 'mat.descricao as nomeMaterial', 'unidade.codigo as codigo_unidade', \DB::raw('SUM(estoque.qtde) as quantidade'), 'mat.qtde_critica as qtde_critica', 'mat.qtde_minima as qtde_minima')
                            ->where('qtde', '>', 0)
                            ->groupBy('mat.id', 'mat.descricao', 'unidade.codigo', 'mat.qtde_minima', 'mat.qtde_critica');
        if($material)
        {
            $estoque = $estoque->where('mat.id','=', $material);
        }

        if($regional)
        {
            $estoque = $estoque->join('cidade as cid' , 'cid.id', '=', 'alm.cidade_id')
                               ->join('regional as reg', 'reg.id', '=', 'cid.regional_id')
                               ->where('reg.id','=', $regional);
        }

        if($almoxarifado){
            $estoque = $estoque->where('estoque.almoxarifado_id', '=', $almoxarifado);
        }

        if($numero_obra){
            $estoque = $estoque->join('obra', 'estoque.obra_id', '=', 'obra.id')
                               ->where('obra.numero_obra', '=', $numero_obra);
        }
        //dd($estoque->toSql());
        return $estoque;
    }

     public static function getEstoqueDetail($material = null, $regional = null, $almoxarifado = null, $obra_id = null)
    {
         $estoque = Estoque::join('tipo_material as mat', 'mat.id', '=', 'estoque.tipo_material_id')
                            ->join('tipo_unidade_medida as unidade', 'unidade.id', '=', 'mat.tipo_unidade_medida_material_id')
                            ->join('almoxarifado as alm', 'alm.id', '=', 'estoque.almoxarifado_id')
                            ->join('cidade as cid' , 'cid.id', '=', 'alm.cidade_id')
                            ->join('regional as reg', 'reg.id', '=', 'cid.regional_id')
                            ->select('mat.id as id','alm.nome as almoxarifado','unidade.codigo as codigo_unidade', \DB::raw('SUM(estoque.qtde) as quantidade'), 'reg.descricao as regional', 'mat.qtde_critica as qtde_critica', 'mat.qtde_minima as qtde_minima')
                            ->where('qtde', '>', 0)
                            ->where('mat.id','=', $material);

        if($regional)
        {
            $estoque = $estoque->where('reg.id','=', $regional);
        }

        if($almoxarifado){
            $estoque = $estoque->where('estoque.almoxarifado_id', '=', $almoxarifado);
        }

        if($obra_id){
            $estoque = $estoque->where('estoque.obra_id', $obra_id);
        }

        return $estoque->groupBy('mat.id','alm.nome', 'mat.descricao', 'unidade.codigo','reg.descricao','alm.nome');
    
    }

        public static function filterPesquisaEstoque($request){

        $result = Estoque::join('obra','obra.id', '=', 'estoque.obra_id')
                         ->join('tipo_material as mat', 'mat.id', '=', 'estoque.tipo_material_id')
                         ->select('estoque.id', 'estoque.almoxarifado_id', 'estoque.tipo_material_id', 'estoque.qtde', 'estoque.obra_id');

        if(!empty($request['cod_inicio']) && !empty($request['cod_fim']))
        {
            $result = $result->whereBetween('tipo.codigo', [ $request['cod_inicio'], $request['cod_fim']] );
        }
        if(!empty($request['numero_obra']))
        {
            $result = $result->where('obra.numero_obra',$request['numero_obra']);
        }
        
        if(!empty($request['almoxarifado']))
        {
            $result = $result->where('estoque.almoxarifado_id', $request['almoxarifado']); 
        }
        
        if(!empty($request['status_obra']))
        {
            $result = $result->where('obra.tipo_status_obra_id',$request['status_obra']);
        }

        if(!empty($request['data_inicio']) && !empty($request['data_final']))
        {
            $data_inicio = $request['data_inicio']." 00:00:00";
            $data_final  = $request['data_final']." 23:59:59";

            $result = $result->join('entrada_estoque', 'entrada_estoque.obra_id', '=', 'estoque.obra_id')
                             ->whereBetween('entrada_estoque.data', [$data_inicio, $data_final]);
        }

        return $result;
    }
}