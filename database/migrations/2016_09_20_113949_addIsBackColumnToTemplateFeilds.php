<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsBackColumnToTemplateFeilds extends Migration
{
    public function up()
    {
         Schema::table('template_feilds', function ($table) {
            $table->boolean('is_back')->default(0);
        });    
     }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('template_feilds', function ($table) {
            $table->dropColumn('is_back');
        });
    }
}
