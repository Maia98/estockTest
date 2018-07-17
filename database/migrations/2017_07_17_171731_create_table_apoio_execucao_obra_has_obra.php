<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableApoioExecucaoObraHasObra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apoio_execucao_obra_has_obra', function(Blueprint $table){

            $table->increments('id');
            $table->integer('apoio_execucao_obra_id');
            $table->integer('obra_id');
            $table->timestamps();


            $table->foreign('apoio_execucao_obra_id')->references('id')->on('tipo_apoio')->onDelete('cascade');
            $table->foreign('obra_id')->references('id')->on('obra')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apoio_execucao_obra_has_obra');
    }
}
