<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTipoMaterialColumnPesoParaConstante extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tipo_material', function(Blueprint $table){
            $table->renameColumn('peso_material', 'constante_material');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tipo_material', function(Blueprint $table){
            $table->renameColumn('constante_material', 'peso_material');
        });
    }
}
