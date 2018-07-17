<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableItensApontamentoMedicao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itens_apontamento_medicao', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('medicao_id');
            $table->integer('apontamento_medicao_id');
            $table->timestamps();

            $table->foreign('medicao_id')->references('id')->on('medicao');
            $table->foreign('apontamento_medicao_id')->references('id')->on('apontamento_medicao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('itens_apontamento_medicao');
    }
}
