<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_districts', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name_sub_districts')->nullable();
            $table->string('province_id')->nullable();
            $table->string('district_id')->nullable();
            $table->string('electorate_id')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sub_districts');
    }
}
