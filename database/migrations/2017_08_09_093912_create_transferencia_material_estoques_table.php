<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateTransferenciaMaterialEstoquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transferencia_material_estoque', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transferencia_estoque_id')->unsigned();
            $table->integer('tipo_material_id')->unsigned();
            $table->integer('obra_origem_id')->unsigned();
            $table->double('qtde');
            $table->timestamps();
            
            $table->foreign('transferencia_estoque_id')->references('id')->on('transferencia_estoque');
            $table->foreign('tipo_material_id')->references('id')->on('tipo_material');
            $table->foreign('obra_origem_id')->references('id')->on('obra');
            
        });


        DB::statement('ALTER TABLE transferencia_material_estoque ADD CONSTRAINT chk_transferencia_materiais_qtde CHECK (qtde >= 0.0);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE transferencia_material_estoque DROP CONSTRAINT IF EXISTS chk_transferencia_materiais_qtde;');
        Schema::dropIfExists('transferencia_material_estoque');
    }
}
