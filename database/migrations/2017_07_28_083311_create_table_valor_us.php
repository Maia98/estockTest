<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableValorUs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('valor_us', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('usuario_id');
            $table->double('valor');
            $table->double('valor_anterior')->nullable();
            $table->timestamps();

            $table->primary('id');
            $table->foreign('usuario_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('valor_us');
    }
}
