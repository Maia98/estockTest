<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterColumnMedidoMedicaoObra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('obra', function(Blueprint $table){
            $table->string('medidor', 800)->change();
            $table->string('instalacao', 800)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('obra', function(Blueprint $table){
            $table->string('medidor', 300)->change();
            $table->string('instalacao', 300)->change();
        });
    }
}
