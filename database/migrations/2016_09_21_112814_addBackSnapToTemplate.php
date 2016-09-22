<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBackSnapToTemplate extends Migration
{
     public function up()
    {
         Schema::table('templates', function ($table) {
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
        Schema::table('templates', function ($table) {
            $table->dropColumn('back_snap');
        });
    }
}
