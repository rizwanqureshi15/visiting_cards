<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFeildsToUserTemplateTable extends Migration
{
     public function up()
    {
         Schema::table('user_templates', function ($table) {
            $table->boolean('is_both_side');
            $table->string('background_image_back');
            $table->string('back_snap');
        });    
     }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_templates', function ($table) {
            $table->dropColumn('is_both_side');
            $table->dropColumn('background_image_back');
             $table->dropColumn('back_snap');
        });
    }
}
