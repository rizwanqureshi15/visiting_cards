<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDivCssToUserTemplateImageTable extends Migration
{
     public function up()
    {
         Schema::table('user_template_images', function ($table) {
            $table->string('div_css');
        });    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_template_images', function ($table) {
            $table->dropColumn('div_css');
        });
    }
}
