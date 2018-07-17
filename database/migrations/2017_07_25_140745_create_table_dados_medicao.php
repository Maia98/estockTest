<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDadosMedicao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::create('dados_medicao', function(Blueprint $table){
            $table->integer('cod_grupo')->nullable();
            $table->integer('cod_mobra');
            $table->string('nome', 500);
            $table->string('descricao',500);
            $table->double('instalar');
            $table->double('retirar');
            $table->double('instalar_emergencial')->nullable();
            $table->double('retirar_emergencial')->nullable();

            $table->primary('cod_mobra');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dados_medicao');
    }
}
