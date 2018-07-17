<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameTipoCidadeToCidade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cidade', function (Blueprint $table){
            $table->increments('id');
            $table->string('nome')->unique();
            $table->integer('regional_id');
            $table->timestamps();

            $table->foreign('regional_id')->references('id')->on('cadastro_regional');
        });
        
        $cidades = \DB::table('tipo_cidade')->get();
    
        foreach ($cidades as $cidade)
        {
            \DB::table('cidade')->insert([
                'id' => $cidade->id,
                'nome' => $cidade->nome, 
                'regional_id' => $cidade->regional_id                
            ]);
        }
        
        if (Schema::hasColumn('almoxarifado', 'tipo_cidade_id')) {
            Schema::table('almoxarifado', function (Blueprint $table) {
                $table->dropForeign(['tipo_cidade_id']);
                $table->renameColumn('tipo_cidade_id', 'cidade_id');
                $table->foreign('cidade_id')->references('id')->on('cidade');
            });
        }
        
        if (Schema::hasColumn('obra', 'tipo_cidade_id')) {
            Schema::table('obra', function (Blueprint $table) {
                $table->dropForeign(['tipo_cidade_id']);
                $table->renameColumn('tipo_cidade_id', 'cidade_id');
                $table->foreign('cidade_id')->references('id')->on('cidade');
            });
        }
        
        \DB::select("SELECT setval('cidade_id_seq', (SELECT GREATEST(MAX(id), nextval('cidade_id_seq')) FROM cidade));");
        
        Schema::dropIfExists('tipo_cidade');
        
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('tipo_cidade', function (Blueprint $table){
            $table->increments('id');
            $table->string('nome')->unique();
            $table->integer('regional_id');
            $table->timestamps();

            $table->foreign('regional_id')->references('id')->on('cadastro_regional');
        });
        
        $cidades = \DB::table('cidade')->get();
    
        foreach ($cidades as $cidade)
        {
            \DB::table('tipo_cidade')->insert([
                'id' => $cidade->id,
                'nome' => $cidade->nome, 
                'regional_id' => $cidade->regional_id                
            ]);
        }
        
        if (Schema::hasColumn('almoxarifado', 'cidade_id')) {
            Schema::table('almoxarifado', function (Blueprint $table) {
                $table->dropForeign(['cidade_id']);
                $table->renameColumn('cidade_id', 'tipo_cidade_id');
                $table->foreign('tipo_cidade_id')->references('id')->on('tipo_cidade');
            });
        }
        
        if (Schema::hasColumn('obra', 'cidade_id')) {
            Schema::table('obra', function (Blueprint $table) {
                $table->dropForeign(['cidade_id']);
                $table->renameColumn('cidade_id', 'tipo_cidade_id');
                $table->foreign('tipo_cidade_id')->references('id')->on('tipo_cidade');
            });
        }
        
        \DB::select("SELECT setval('tipo_cidade_id_seq', (SELECT GREATEST(MAX(id), nextval('tipo_cidade_id_seq')) FROM tipo_cidade));");
        
        Schema::dropIfExists('cidade');
    }
}
