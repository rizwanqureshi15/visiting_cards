<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TemplateFeilds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('template_feilds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('template_id');
            $table->text('css');
            $table->text('font_css');
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
        //
        Schema::drop('template_feilds');
    }
}
