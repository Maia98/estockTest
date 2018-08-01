<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('form_id');
<<<<<<< HEAD
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
            $table->string('type_id');
=======
<<<<<<< HEAD
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
            $table->string('type_id');
=======
            $table->foreign('form_id')->references('id')->on('forms');
            $table->integer('list_item_id');
            $table->foreign('list_item_id')->references('id')->on('list_items');
            $table->integer('field_type_id');
            $table->foreign('field_type_id')->references('id')->on('field_types');
>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
            $table->string('label', 255);
            $table->tinyinteger('required');
            $table->tinyinteger('private');
            $table->tinyinteger('edit_mask')->nullable();
<<<<<<< HEAD
            $table->string('name', 64);
=======
            $table->string('name', 64)->unique();
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
            $table->text('configuration')->nullable();
            $table->integer('sort')->nullable();
            $table->string('hint', 512)->nullable();
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
        Schema::dropIfExists('form_fields');
    }
}
