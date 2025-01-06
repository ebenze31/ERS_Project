<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('candidate_id')->nullable();
            $table->string('yesr_id')->nullable();
            $table->string('polling_unit_id')->nullable();
            $table->string('sub_district_id')->nullable();
            $table->string('electorate_id')->nullable();
            $table->string('district_id')->nullable();
            $table->string('province_id')->nullable();
            $table->integer('score')->nullable();
            $table->string('round')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('scores');
    }
}
