<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FuncionarioEncarregadoHasObra extends Model
{
    protected $table    = "funcionario_encarregado_has_obra";
    protected $fillable = ['funcionario_id', 'obra_id'];

    public function obra()
    {
      return $this->belongsTo('App\Model\Obra', 'obra_id', 'id');
    }

     public function encarregado()
    {
      return $this->belongsTo('App\Model\Funcionario', 'funcionario_id', 'id');
    }

}