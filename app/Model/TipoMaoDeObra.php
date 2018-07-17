<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TipoMaoDeObra extends Model
{
    protected $table    = "tipo_mao_de_obra";
    protected $fillable = ['nome'];
}
