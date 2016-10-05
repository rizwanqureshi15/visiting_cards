<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsConfirmedInOrderTable extends Migration
{
    public function up()
    {
         Schema::table('orders', function ($table) {
            $table->boolean('is_confirmed')->default(0);
        });    
     }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function ($table) {
            $table->dropColumn('is_confirmed');
        });
    }
}
