<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameCadastroRegionalToRegional extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regional', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao')->unique();
            $table->timestamps();
        });
        
        $regionais = \DB::table('cadastro_regional')->get();
    
        foreach ($regionais as $regional)
        {
            \DB::table('regional')->insert([
                'id' => $regional->id,
                'descricao' => $regional->descricao                
            ]);
        }
        
        if (Schema::hasColumn('cidade', 'regional_id')) {
            Schema::table('cidade', function (Blueprint $table) {
                $table->dropForeign(['regional_id']);
                $table->foreign('regional_id')->references('id')->on('regional');
            });
        }
        
        \DB::statement("SELECT setval('regional_id_seq', (SELECT GREATEST(MAX(id), nextval('regional_id_seq')) FROM regional));");
        
        Schema::dropIfExists('cadastro_regional');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('cadastro_regional', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao')->unique();
            $table->timestamps();
        });
        
        $regionais = \DB::table('regional')->get();
    
        foreach ($regionais as $regional)
        {
            \DB::table('cadastro_regional')->insert([
                'id' => $regional->id,
                'descricao' => $regional->descricao                
            ]);
        }
        
        if (Schema::hasColumn('cidade', 'regional_id')) {
            Schema::table('cidade', function (Blueprint $table) {
                $table->dropForeign(['regional_id']);
                $table->foreign('regional_id')->references('id')->on('cadastro_regional');
            });
        }
        
        \DB::statement("SELECT setval('cadastro_regional_id_seq', (SELECT GREATEST(MAX(id), nextval('cadastro_regional_id_seq')) FROM cadastro_regional));");
        Schema::dropIfExists('regional');
    }
}
