<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColumnCodigoTipoUnidade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('tipo_unidade', 'tipo_unidade_medida');
        Schema::table('tipo_unidade_medida', function(Blueprint $table){
            $table->string('codigo', 10)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('tipo_unidade_medida', 'tipo_unidade');
//        Schema::table('tipo_unidade', function(Blueprint $table){
//            $table->integer('codigo')->change();
//        });
        DB::statement('ALTER TABLE tipo_unidade ALTER COLUMN codigo TYPE integer USING (codigo::integer);');
    }
}
