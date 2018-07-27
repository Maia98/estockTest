<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type', 8)->nullable();
            $table->tinyinteger('deletable')->default(1);
<<<<<<< HEAD
            $table->string('nametable')->unique();
=======
>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
            $table->string('title');
            $table->string('instructions', 512)->nullable();
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('forms');
    }
}
