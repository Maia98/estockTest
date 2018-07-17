<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTipoMaterial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tipo_material', function(Blueprint $table){

            DB::statement('ALTER TABLE "tipo_material" ALTER COLUMN "peso_material" DROP NOT NULL, ALTER COLUMN "valor_material" DROP NOT NULL, ALTER COLUMN "qtde_minima" DROP NOT NULL, ALTER COLUMN "qtde_critica" DROP NOT NULL;');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tipo_material', function(Blueprint $table){

            DB::statement('ALTER TABLE "tipo_material" ALTER COLUMN "peso_material" SET NOT NULL, ALTER COLUMN "valor_material" SET NOT NULL, ALTER COLUMN "qtde_minima" SET NOT NULL, ALTER COLUMN "qtde_critica" SET NOT NULL;');
            

        });
    }
}
