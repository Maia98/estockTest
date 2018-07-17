<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class TransferenciaMaterialEstoque extends Model
{
    protected $table    = "transferencia_material_estoque";
    protected $fillable = ['transferencia_estoque_id', 'tipo_material_id', 'obra_origem_id', 'qtde','qtde_obra_origem'];

    public function obraOrigem(){

        return $this->belongsTo('App\Model\Obra', 'obra_origem_id', 'id');
    }

    public  function material(){
        return $this->belongsTo('App\Model\TipoMaterial', 'tipo_material_id', 'id');
    }
}
