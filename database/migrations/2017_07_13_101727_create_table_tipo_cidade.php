<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTipoCidade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_cidade', function (Blueprint $table){
            $table->increments('id');
            $table->string('nome', 500)->unique();
            $table->integer('regional_id');
            $table->timestamps();

            $table->foreign('regional_id')->references('id')->on('cadastro_regional');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_cidade');
    }
}
