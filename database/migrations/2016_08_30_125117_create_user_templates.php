<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTemplates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('template_id');
            $table->string('background_image');
            $table->string('url');
            $table->string('type');
            $table->boolean('is_delete');
            $table->integer('user_id')->unsigned();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_templates');
    }
}
