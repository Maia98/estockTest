<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialOrcado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_orcado', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero_obra');
            $table->integer('cod_mat');
            $table->string('descricao_mat',100);
            $table->double('qtd_orc');
            $table->timestamps();

            $table->foreign('numero_obra')->references('numero_obra')->on('obra');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('material_orcado');
    }
}
