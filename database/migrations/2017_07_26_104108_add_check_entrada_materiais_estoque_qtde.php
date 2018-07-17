<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCheckEntradaMateriaisEstoqueQtde extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE entrada_material_estoque ADD CONSTRAINT chk_entrada_materiais_qtde CHECK (qtde >= 0.0);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE entrada_material_estoque DROP CONSTRAINT IF EXISTS chk_entrada_materiais_qtde;');
    }
}
