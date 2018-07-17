<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterColumnsMedidorInstalacaoObra extends Migration
{
    public function up()
    {
        Schema::table('obra', function(Blueprint $table){
            $table->text('medidor')->change();
            $table->text('instalacao')->change();
        });
    }

    public function down()
    {
        Schema::table('obra', function(Blueprint $table){
            $table->string('medidor', 800)->change();
            $table->string('instalacao', 800)->change();
        });
    }
}
