<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsLabelColumnToUserTemplateFeildTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
         Schema::table('user_template_feilds', function ($table) {
            $table->boolean('is_label');
        });    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_template_feils', function ($table) {
            $table->dropColumn('is_label');
        });
    }
}
