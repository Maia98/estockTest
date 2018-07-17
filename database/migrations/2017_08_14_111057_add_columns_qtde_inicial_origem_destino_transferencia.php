<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsQtdeInicialOrigemDestinoTransferencia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transferencia_material_estoque', function (Blueprint $table){
            $table->double('qtde_obra_origem')->default(0);
            $table->double('qtde_obra_destino')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transferencia_material_estoque', function (Blueprint $table){
            if(Schema::hasColumn('transferencia_material_estoque', 'qtde_obra_origem')){
                $table->dropColumn('qtde_obra_origem');
            }

            if(Schema::hasColumn('transferencia_material_estoque', 'qtde_obra_destino')){

                $table->dropColumn('qtde_obra_destino');
            }

        });
    }
}
