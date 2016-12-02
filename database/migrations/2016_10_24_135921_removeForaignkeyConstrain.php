<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveForaignkeyConstrain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_templates', function ($table) {
            $table->integer('user_id')->unsigned()->change();
            $table->dropForeign(['user_id']);
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
            $table->foreign('user_id')->references('id')->on('users');
        });
        
    }
}
