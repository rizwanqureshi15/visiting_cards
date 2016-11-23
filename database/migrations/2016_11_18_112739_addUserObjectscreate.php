<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserObjectscreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('user_objects',function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('css');
            $table->integer('template_id');
            $table->boolean('is_back');
            $table->string('type');
            $table->string('line_css');
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
        Schema::drop('user_objects');
    }
}
