<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SaidaMaterialEstoque extends Model
{
    protected $table    = "saida_material_estoque";
    protected $fillable = ['saida_estoque_id', 'tipo_material_id', 'qtde'];
    
    public function saidaEstoque(){
        
        return $this->belongsTo('App\Model\SaidaEstoque', 'saida_estoque_id', 'id');
    }

    public function tipoMaterial(){
        
        return $this->belongsTo('App\Model\TipoMaterial', 'tipo_material_id', 'id');
    }
}