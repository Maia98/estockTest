<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColumnAlmoxarifado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('almoxarifado', function (Blueprint $table) {
            $table->string('descricao')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('almoxarifado', function (Blueprint $table) {
            $table->string('descricao')->nullable(false)->change();
        });
    }
}
