<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSlider extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('slider');
        Schema::create('slider', function (Blueprint $table) {
            $table->increments('id');
            // $table->primary('id');
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->string('link', 200);
            $table->text('thumb')->nullable();
            $table->dateTime('created')->nullable();
            $table->string('created_by', 255)->nullable();
            $table->dateTime('modified')->nullable();
            $table->string('modified_by', 255)->nullable();
            $table->text('status')->nullable();
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
        Schema::dropIfExists('slider');
    }
}
