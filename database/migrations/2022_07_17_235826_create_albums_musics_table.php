<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumsMusicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albums_musics', function (Blueprint $table) {
            $table->unsignedInteger('id_album');
            $table->unsignedInteger('id_music');
            $table->integer('track');
            $table->string('id_language', 5);
            $table->timestamps();

            $table->primary(['id_album', 'id_music']);
            $table->foreign('id_album')->references('id_album')->on('albums');
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
        Schema::dropIfExists('albums_musics');
    }
}
