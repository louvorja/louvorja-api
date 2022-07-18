<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLyricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lyrics', function (Blueprint $table) {
            $table->increments('id_lyric');
            $table->unsignedInteger('id_music');
            $table->string('lyric');
            $table->string('image');
            $table->time('time');
            $table->time('instrumental_time');
            $table->boolean('show_slide');
            $table->integer('order');
            $table->string('id_language', 5);
            $table->timestamps();

            $table->foreign('id_music')->references('id_music')->on('musics');
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
        Schema::dropIfExists('lyrics');
    }
}
