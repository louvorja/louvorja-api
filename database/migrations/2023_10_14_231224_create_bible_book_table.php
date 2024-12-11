<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBibleBookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bible_book', function (Blueprint $table) {
            $table->increments('id_bible_book');
            $table->integer('book_number');
            $table->string('name');
            $table->tinyInteger('testament');
            $table->string('keywords')->nullable();
            $table->string('abbreviation', 5);
            $table->string('id_language', 5);
            $table->timestamps();

            $table->foreign('id_language')->references('id_language')->on('languages');
            $table->unique(['book_number', 'id_language']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bible_book');
    }
}
