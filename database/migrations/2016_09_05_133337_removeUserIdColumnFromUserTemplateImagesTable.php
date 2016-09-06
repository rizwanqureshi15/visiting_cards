<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUserIdColumnFromUserTemplateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('user_template_images', function ($table) {
            $table->dropColumn('user_id');
        });
    }


    public function down()
    {
        Schema::table('user_template_images', function ($table) {
            $table->string('user_id');
        });
    }
}
