<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ItensMedicao extends Model
{
    protected $table    = "itens_medicao";
    protected $fillable = ['medicao_obra_id', 'cod_mobra', 'tipo_mao_obra_id', 'nome_mobra',
        'descricao_mobra', 'qtde', 'valor_us', 'valor_unitario', 'sub_total'];

    public function tipoMaoObra()
    {
        $tipoMaoObra = \DB::table('tipo_mao_de_obra')->select('nome')->where('id', $this->tipo_mao_obra_id)->first();
        
        return $tipoMaoObra->nome;
    }
}