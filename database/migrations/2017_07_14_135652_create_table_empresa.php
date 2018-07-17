<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEmpresa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa', function (Blueprint $table){
            $table->increments('id');
            $table->string('cnpj', 14)->unique();
            $table->string('razao_social', 45)->nullable();
            $table->string('nome_fantasia', 50)->nullable();
            $table->string('insc_estadual', 45)->nullable();
            $table->string('email', 45)->nullable();
            $table->string('cep', 8)->nullable();
            $table->string('logradouro', 200)->nullable();
            $table->string('numero', 10)->nullable();
            $table->string('complemento', 100)->nullable();
            $table->string('bairro', 50)->nullable();
            $table->string('cidade', 50)->nullable();
            $table->string('uf', 2)->nullable();
            $table->string('telefone', 10)->nullable();
            $table->string('celular', 11)->nullable();

            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresa');
    }
}
