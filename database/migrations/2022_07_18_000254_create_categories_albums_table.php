<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories_albums', function (Blueprint $table) {
            $table->unsignedInteger('id_category');
            $table->unsignedInteger('id_album');
            $table->string('name');
            $table->integer('order');
            $table->string('id_language', 5);
            $table->timestamps();

            $table->primary(['id_category', 'id_album']);
            $table->foreign('id_category')->references('id_category')->on('categories');
            $table->foreign('id_album')->references('id_album')->on('albums');
            $table->foreign('id_language')->references('id_language')->on('languages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories_albums');
    }
}
