<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableArticle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('article');
        Schema::create('article', function (Blueprint $table) {
            $table->increments('id');
            // $table->primary('id');
            $table->integer('category_id');
            $table->string('name', 255);
            $table->text('content')->nulable();
            $table->string('status', 225)->nullable();
            $table->string('thumb', 255)->nullable();
            $table->dateTime('created')->nullable();
            $table->string('created_by', 255)->nullable();
            $table->dateTime('modified')->nullable();
            $table->string('modified_by', 255)->nullable();
            $table->date('publish_at')->nullable();
            $table->string('type', 255)->nullable();
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
        Schema::dropIfExists('article');
    }
}




