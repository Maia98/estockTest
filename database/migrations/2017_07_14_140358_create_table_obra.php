<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableObra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::create('obra', function (Blueprint $table){
            $table->increments('id');
            $table->integer('tipo_setor_obra_id');
            $table->integer('tipo_obra_id');
            $table->integer('tipo_cidade_id');
            $table->integer('funcionario_supervisor_id')->nullable();
            $table->integer('funcionario_fiscal_id')->nullable();
            $table->integer('tipo_status_obra_id');
            $table->integer('tipo_prioridade_obra_id');
            $table->integer('numero_obra')->unique();
            $table->dateTime('data_abertura')->nullable();
            $table->dateTime('data_recebimento');
            $table->dateTime('data_previsao_retirada_material')->nullable();
            $table->dateTime('prazo_execucao_inicio')->nullable();
            $table->dateTime('prazo_execucao_fim')->nullable();
            $table->double('valor_orcado')->nullable();
            $table->string('medidor',300)->nullable();
            $table->string('instalacao',300)->nullable();
            $table->string('observacao',500)->nullable();
            $table->timestamps();

            $table->foreign('tipo_setor_obra_id')->references('id')->on('tipo_setor_obra');
            $table->foreign('tipo_obra_id')->references('id')->on('tipo_obra');
            $table->foreign('tipo_cidade_id')->references('id')->on('tipo_cidade');
            $table->foreign('funcionario_supervisor_id')->references('id')->on('funcionarios');
            $table->foreign('funcionario_fiscal_id')->references('id')->on('funcionarios');
            $table->foreign('tipo_status_obra_id')->references('id')->on('status_obra');
            $table->foreign('tipo_prioridade_obra_id')->references('id')->on('tipo_prioridade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('obra');
    }
}
