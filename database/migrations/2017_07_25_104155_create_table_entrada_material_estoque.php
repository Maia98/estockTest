<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEntradaMaterialEstoque extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrada_material_estoque', function(Blueprint $table){
            $table->increments('id');
            $table->integer('entrada_estoque_id');
            $table->integer('tipo_material_id');
            $table->double('qtde');
            $table->timestamps();

            $table->foreign('entrada_estoque_id')->references('id')->on('entrada_estoque');
            $table->foreign('tipo_material_id')->references('id')->on('tipo_material');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entrada_material_estoque');
    }
}
