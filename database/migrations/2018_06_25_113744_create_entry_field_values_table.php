<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntryFieldValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entry_field_values', function (Blueprint $table) {
            //$table->increments('id');
            $table->integer('entry_id');
            $table->foreign('entry_id')->references('id')->on('form_entries')->onDelete('cascade');;
            $table->integer('field_id');
            $table->foreign('field_id')->references('id')->on('form_fields')->onDelete('cascade');;
            $table->text('value');
            $table->integer('value_id');
           // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entry_field_values');
    }
}
