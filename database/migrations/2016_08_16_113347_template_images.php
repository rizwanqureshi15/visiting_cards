<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TemplateImages extends Migration
{
    public function up()
    {
        //
         Schema::create('template_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('template_id');
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
        //
        Schema::drop('template_images');
    }
}
