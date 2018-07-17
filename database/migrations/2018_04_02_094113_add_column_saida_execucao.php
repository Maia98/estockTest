<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnSaidaExecucao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('saida_estoque', function(Blueprint $table){
            $table->date('execucao')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('saida_estoque', function (Blueprint $table) {
            if(Schema::hasColumn('saida_estoque', 'execucao')){
                $table->dropColumn('execucao');
            }
        });
    }
}
