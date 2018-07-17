<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTipoSetorObra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
 public function up()
    {
        Schema::create('tipo_setor_obra', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao', 500);
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
        Schema::dropIfExists('tipo_setor_obra');
    }
}
