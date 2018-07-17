<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFuncionarioEncarregadoHasObra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcionario_encarregado_has_obra', function(Blueprint $table){

            $table->increments('id');
            $table->integer('funcionario_id');
            $table->integer('obra_id');
            $table->timestamps();


            $table->foreign('funcionario_id')->references('id')->on('funcionarios');
            $table->foreign('obra_id')->references('id')->on('obra');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('funcionario_encarregado_has_obra'); 
    }
}
