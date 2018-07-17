<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTipoMaterial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_material', function (Blueprint $table){
            $table->increments('id');
            $table->integer('codigo');
            $table->string('descricao',300);
            $table->integer('tipo_unidade_medida_material_id');
            $table->double('peso_material');
            $table->double('valor_material');
            $table->integer('qtde_minima');
            $table->integer('qtde_critica');

            $table->foreign('tipo_unidade_medida_material_id')->references('id')->on('tipo_unidade');
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_material');
    }
}
