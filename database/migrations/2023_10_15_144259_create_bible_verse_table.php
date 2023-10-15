<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBibleVerseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bible_verse', function (Blueprint $table) {
            $table->increments('id_bible_verse');
            $table->unsignedInteger('id_bible_version');
            $table->unsignedInteger('id_bible_book');
            $table->integer('chapter');
            $table->integer('verse');
            $table->text('text');
            $table->string('id_language', 5);
            $table->timestamps();

            $table->foreign('id_bible_version')->references('id_bible_version')->on('bible_version');
            $table->foreign('id_bible_book')->references('id_bible_book')->on('bible_book');
            $table->foreign('id_language')->references('id_language')->on('languages');

            $table->unique(['id_bible_version', 'id_bible_book', 'chapter', 'verse']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bible_verse');
    }
}
