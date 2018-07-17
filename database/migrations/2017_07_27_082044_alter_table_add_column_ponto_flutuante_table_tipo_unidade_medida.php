<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAddColumnPontoFlutuanteTableTipoUnidadeMedida extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tipo_unidade_medida', function(Blueprint $table){
            $table->boolean('ponto_flutuante')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tipo_unidade_medida', function(Blueprint $table){
            $table->dropColumn('ponto_flutuante');
        });
    }
}
