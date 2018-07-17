<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTipoUnidade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tipo_unidade', function(Blueprint $table){
            $table->unique('codigo');
            $table->unique('descricao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tipo_unidade', function(Blueprint $table){
            $table->dropUnique('tipo_unidade_codigo_unique');
            $table->dropUnique('tipo_unidade_descricao_unique');
        });
    }
}
