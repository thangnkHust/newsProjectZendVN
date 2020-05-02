<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('category');
        Schema::create('category', function (Blueprint $table) {
            $table->increments('id');
            // $table->primary('id');
            $table->string('name', 255);
            $table->text('status');
            $table->dateTime('created')->nullable();
            $table->string('created_by', 255)->nullable();
            $table->dateTime('modified')->nullable();
            $table->string('modified_by', 255)->nullable();
            $table->tinyInteger('is_home')->nullable();
            $table->string('display', 255)->nullable();
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
        Schema::dropIfExists('category');
    }
}
