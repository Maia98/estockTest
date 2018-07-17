<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMateriais extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materiais', function(Blueprint $table){
            $table->increments('id');
            $table->integer('almoxarifado_id');
            $table->integer('tipo_material_id');
            $table->double('qtde');

            $table->timestamps();

            $table->foreign('almoxarifado_id')->references('id')->on('almoxarifado');
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
        Schema::dropIfExists('materiais');
    }
}
