<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTemplateFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_template_feilds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('template_id');
            $table->integer('user_id');
            $table->text('css');
            $table->text('font_css');
            $table->text('content');
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
        Schema::drop('user_template_feilds');
    }
}
