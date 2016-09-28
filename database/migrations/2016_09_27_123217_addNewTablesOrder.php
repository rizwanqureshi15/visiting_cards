<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewTablesOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('material_id');
            $table->decimal('amount',6,2);
            $table->integer('quantity');
            $table->string('order_no');
            $table->string('status');
            $table->boolean('is_delete');
            $table->boolean('is_cancel');
            $table->timestamps();
        }); 

        Schema::create('order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->string('front_snap');
            $table->string('back_snap');
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
        Schema::drop('orders');
        Schema::drop('order_items');
    }
}
