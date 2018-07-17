<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterColumnObservacaoObra extends Migration
{
    public function up()
    {
        Schema::table('obra', function(Blueprint $table){
            $table->text('observacao')->change();
        });
    }

    public function down()
    {
        Schema::table('obra', function(Blueprint $table){
            $table->string('observacao', 500)->change();
        });
    }
}
