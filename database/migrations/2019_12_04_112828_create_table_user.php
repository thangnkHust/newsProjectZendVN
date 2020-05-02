<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('user');
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            // $table->primary('id');
            $table->string('username', 255);
            $table->string('email', 255)->nullable();
            $table->string('fullname', 255)->nullable();
            $table->string('password', 255)->nullable();
            $table->string('avatar', 255)->nullable();
            $table->string('level', 10)->nullable();
            $table->dateTime('created')->nullable();
            $table->string('created_by', 255)->nullable();
            $table->dateTime('modified')->nullable();
            $table->string('modified_by', 255)->nullable();
            $table->string('status', 10)->default('0');
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
        Schema::dropIfExists('user');
    }
}
