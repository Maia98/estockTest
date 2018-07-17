<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUfEstado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uf_estado', function(Blueprint $table){
            $table->increments('id');
            $table->string('uf', 2);
            $table->string('estado',30);
        });


        DB::table('uf_estado')->insert(
            array(
                array('estado' => 'Acre', 'uf' => 'AC'),
                array('estado' => 'Alagoas', 'uf' => 'AL'),
                array('estado' => 'Amapá', 'uf' => 'AP'),
                array('estado' => 'Amazonas', 'uf' => 'AM'),
                array('estado' => 'Bahia', 'uf' => 'BA'),
                array('estado' => 'Ceará', 'uf' => 'CE'),
                array('estado' => 'Distrito Federal', 'uf' => 'DF'),
                array('estado' => 'Espírito Santo', 'uf' => 'ES'),
                array('estado' => 'Goiás', 'uf' => 'GO'),
                array('estado' => 'Maranhão', 'uf' => 'MA'),
                array('estado' => 'Mato Grosso', 'uf' => 'MT'),
                array('estado' => 'Mato Grosso do Sul', 'uf' => 'MS'),
                array('estado' => 'Minas Gerais', 'uf' => 'MG'),
                array('estado' => 'Pará', 'uf' => 'PA'),
                array('estado' => 'Paraíba', 'uf' => 'PB'),
                array('estado' => 'Paraná', 'uf' => 'PR'),
                array('estado' => 'Pernambuco', 'uf' => 'PE'),
                array('estado' => 'Piauí', 'uf' => 'PI'),
                array('estado' => 'Rio de Janeiro', 'uf' => 'RJ'),
                array('estado' => 'Rio Grande do Norte', 'uf' => 'RN'),
                array('estado' => 'Rio Grande do Sul', 'uf' => 'RS'),
                array('estado' => 'Rondônia', 'uf' => 'RO'),
                array('estado' => 'Roraima', 'uf' => 'RR'),
                array('estado' => 'Santa Catarina', 'uf' => 'SC'),
                array('estado' => 'São Paulo', 'uf' => 'SP'),
                array('estado' => 'Sergipe', 'uf' => 'SE'),
                array('estado' => 'Tocantins', 'uf' => 'TO'),
            )
        );

        Schema::table('empresa', function (Blueprint $table) {
            $table->dropColumn('uf');
            $table->integer('uf_id');
            $table->foreign('uf_id')->references('id')->on('uf_estado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empresa', function (Blueprint $table) {
            $table->dropForeign('empresa_uf_id_foreign');
            $table->dropColumn('uf_id');
            $table->string('uf', 2);
        });

        Schema::dropIfExists('uf_estado');
    }
}
