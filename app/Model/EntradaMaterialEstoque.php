<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class EntradaMaterialEstoque extends Model
{
    protected $table    = "entrada_material_estoque";
    protected $fillable = ['entrada_estoque_id', 'tipo_material_id', 'qtde'];
    
    public function entradaEstoque(){
        
        return $this->belongsTo('App\Model\EntradaEstoque', 'entrada_estoque_id', 'id');
    }

    public function tipoMaterial(){
        
        return $this->belongsTo('App\Model\TipoMaterial', 'tipo_material_id', 'id');
    }
}