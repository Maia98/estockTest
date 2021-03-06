<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRegistroEntradaEstoque extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registro_entrada_estoque', function (Blueprint $table){
            $table->increments('id');
            $table->integer('obra_id');
            $table->integer('usuario_id');
            $table->integer('almoxarifado_id');
            $table->integer('funcionario_conferente_id');
            $table->integer('tipo_entrada_estoque_id');
            $table->dateTime('data');
            $table->string('obs',500)->nullable();
            $table->timestamps();

            $table->foreign('obra_id')->references('id')->on('obra');
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->foreign('almoxarifado_id')->references('id')->on('almoxarifado');
            $table->foreign('funcionario_conferente_id')->references('id')->on('funcionarios');
            $table->foreign('tipo_entrada_estoque_id')->references('id')->on('tipo_entrada');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registro_entrada_estoque');
    }
}
