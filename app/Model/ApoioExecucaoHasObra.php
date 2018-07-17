<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ApoioExecucaoHasObra extends Model
{
    protected $table    = "apoio_execucao_obra_has_obra";
    protected $fillable = ['apoio_execucao_obra_id', 'obra_id'];

    public function obra()
    {
      return $this->belongsTo('App\Model\Obra', 'obra_id', 'id');
    }

     public function apoio()
    {
      return $this->belongsTo('App\Model\TipoApoio', 'apoio_execucao_obra_id', 'id');
    }

}