<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSaidaMaterialEstoque extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saida_material_estoque', function(Blueprint $table){
            $table->increments('id');
            $table->integer('saida_estoque_id');
            $table->integer('tipo_material_id');
            $table->double('qtde');
            $table->timestamps();

            $table->foreign('saida_estoque_id')->references('id')->on('saida_estoque');
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
        Schema::dropIfExists('saida_material_estoque');
    }
}