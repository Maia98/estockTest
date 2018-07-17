<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableItensMedicao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itens_medicao', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('medicao_id');
            $table->integer('cod_mobra');
            $table->integer('tipo_mao_obra_id');
            $table->string('nome_mobra', 500);
            $table->string('descricao_mobra', 500);
            $table->integer('qtde');
            $table->double('valor_us');
            $table->double('valor_unitario');
            $table->double('sub_total');
            $table->timestamps();

            $table->foreign('medicao_id')->references('id')->on('medicao');
            $table->foreign('tipo_mao_obra_id')->references('id')->on('tipo_mao_de_obra');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('itens_medicao');
    }
}
