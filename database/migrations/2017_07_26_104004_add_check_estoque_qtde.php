<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCheckEstoqueQtde extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE estoque ADD CONSTRAINT chk_estoque_qtde CHECK (qtde >= 0.0);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE estoque DROP CONSTRAINT IF EXISTS chk_estoque_qtde;');
    }
}
