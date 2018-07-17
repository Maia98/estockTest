<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ItensApontamentoMedicao extends Model
{
    protected $table    = "itens_apontamento_medicao";
    protected $fillable = ['medicao_id', 'apontamento_medicao_id'];

}