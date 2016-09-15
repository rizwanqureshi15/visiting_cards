<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteColumnsFromUserTemplateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::table('user_template_images', function ($table) {
            $table->dropColumn('css');
            $table->dropColumn('div_css');
            $table->dropColumn('template_id');
            $table->dropColumn('shape');
            $table->integer('template_feild_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_template_images', function ($table) {
            $table->string('css');
            $table->string('div_css');
            $table->string('shape');
            $table->integer('template_id');
            $table->dropColumn('template_feild_id');
        });
    }
}
