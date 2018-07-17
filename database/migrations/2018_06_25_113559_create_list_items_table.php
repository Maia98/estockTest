<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lista_id')->unsigned();
            $table->foreign('lista_id')->references('id')->on('listas')->onDelete('cascade');
            $table->tinyinteger('status')->default(1);
            $table->string('value');
            $table->string('extra')->nullable();
            $table->integer('sort')->nullable();
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
        Schema::dropIfExists('list_items');
    }
}
