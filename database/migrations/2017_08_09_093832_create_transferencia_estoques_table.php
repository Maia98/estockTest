<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransferenciaEstoquesTable extends Migration
{
    public function up()
    {
        Schema::create('transferencia_estoque', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('almoxarifado_origem_id')->unsigned();
            $table->integer('almoxarifado_destino_id')->unsigned();
            $table->integer('obra_destino_id')->unsigned();
            $table->date('data');
            $table->integer('usuario_id')->unsigned();
            $table->text('obs')->nullable();
            $table->timestamps();

            $table->foreign('almoxarifado_origem_id')->references('id')->on('almoxarifado');
            $table->foreign('almoxarifado_destino_id')->references('id')->on('almoxarifado');
            $table->foreign('obra_destino_id')->references('id')->on('obra');
            $table->foreign('usuario_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transferencia_estoque');
    }
}
