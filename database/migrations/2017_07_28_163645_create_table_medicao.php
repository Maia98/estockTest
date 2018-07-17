<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMedicao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicao', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('obra_id');
            $table->integer('usuario_id');
            $table->integer('funcionario_fiscal_id')->nullable();
            $table->integer('status_medicao_id');
            $table->date('data_medicao');
            $table->double('valor_pago')->nullable();
            $table->string('observacao',500)->nullable();
            $table->timestamps();

            $table->foreign('obra_id')->references('id')->on('obra');
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->foreign('funcionario_fiscal_id')->references('id')->on('funcionarios');
            $table->foreign('status_medicao_id')->references('id')->on('tipo_status_medicao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medicao');
    }
}
