<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ValorUS extends Model
{
    protected $table    = "valor_us";
    protected $fillable = ['usuario_id', 'valor', 'valor_anterior'];

    public function usuario(){

        return $this->belongsTo('App\Model\Users', 'usuario_id', 'id');
    }
}