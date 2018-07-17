<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAlmoxarifado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('almoxarifado', function (Blueprint $table){
            $table->increments('id');
            $table->string('nome', 200)->unique();
            $table->integer('tipo_cidade_id');
            $table->string('descricao',500);
            $table->timestamps();

            $table->foreign('tipo_cidade_id')->references('id')->on('tipo_cidade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('almoxarifado');
    }
}
