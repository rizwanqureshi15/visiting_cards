<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPriceInTemplate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('templates', function ($table) {
            $table->integer('price');
        });

        Schema::table('user_templates', function ($table) {
            $table->integer('price');
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
            $table->dropColumn('price');
        });

        Schema::table('user_templates', function ($table) {
            $table->dropColumn('price');
        });
    }
}
