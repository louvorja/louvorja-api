<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->increments('id_album');
            $table->string('name')->nullable();
            $table->unsignedInteger('id_file_image')->nullable();
            $table->string('id_language', 5);
            $table->timestamps();

            $table->foreign('id_language')->references('id_language')->on('languages');
            $table->foreign('id_file_image')->references('id_file')->on('files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('albums');
    }
}
