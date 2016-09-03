<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTemplatesImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_template_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('template_id');
            $table->integer('user_id');
            $table->string('src');
            $table->text('css');
            $table->string('shape');
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
        Schema::drop('user_template_images');
    }
}
