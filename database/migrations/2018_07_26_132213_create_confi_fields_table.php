<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfiFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('confi_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('formfield_id')->references('id')->on('forms_fields')->onDelete('cascade');
            $table->integer('size')->nullable();
            $table->integer('width')->nullable();
            //-validate -> por enquanto não precisa criar essa coluna.
            $table->string('placeholder', 255)->nullable();
            $table->string('msgvalidate', 255)->nullable(); 
            $table->string('spacereser', 255)->nullable(); 
            $table->text('helptext')->nullable();
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
        Schema::dropIfExists('confi_fields');
    }
}
