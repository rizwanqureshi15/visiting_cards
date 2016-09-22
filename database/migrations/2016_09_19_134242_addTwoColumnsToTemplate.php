<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTwoColumnsToTemplate extends Migration
{
     public function up()
    {
         Schema::table('templates', function ($table) {
            $table->boolean('is_both_side');
            $table->string('background_image_back');
        });    
     }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('templates', function ($table) {
            $table->dropColumn('is_both_side');
            $table->dropColumn('background_image_back');
        });
    }
}
