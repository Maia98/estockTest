<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRegistroHistoricoObra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::create('registro_historico_obra', function(Blueprint $table){
            $table->increments('id');
            $table->integer('obra_id');
            $table->integer('usuario_id');
            $table->string('status_obra',200);
            $table->string('descricao', 500);
            $table->timestamps();

            $table->foreign('obra_id')->references('id')->on('obra');
            $table->foreign('usuario_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registro_historico_obra');
    }
}
