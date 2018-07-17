<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableEstoque extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Estoque::all()->delete();

        Schema::table('estoque', function(Blueprint $table){
            $table->integer('obra_id');
            $table->foreign('obra_id')->references('id')->on('obra');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('estoque', function(Blueprint $table){
            $table->dropForeign(['obra_id']);
            $table->dropColumn('obra_id');
        });
    }
}
