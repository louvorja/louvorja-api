<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id_file');
            $table->string('name',100);
            $table->string('type');
            $table->integer('size');
            $table->string('base_dir',100);
            $table->string('base_url',100);
            $table->string('subdirectory',100);
            $table->string('file_name',100);
            $table->integer('version');
            $table->timestamps();

            $table->unique(['name','base_url','subdirectory','file_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
