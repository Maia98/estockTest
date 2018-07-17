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
            $table->foreign('form_id')->references('id')->on('forms');
            $table->integer('list_item_id');
            $table->foreign('list_item_id')->references('id')->on('list_items');
            $table->string('type', 255);
            $table->string('label', 255);
            $table->tinyinteger('required');
            $table->tinyinteger('private');
            $table->tinyinteger('edit_mask');
            $table->string('name', 64);
            $table->text('configuration');
            $table->integer('sort');
            $table->string('hint', 512);
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
