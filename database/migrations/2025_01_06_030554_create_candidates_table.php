<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name')->nullable();
            $table->string('img')->nullable();
            $table->string('number')->nullable();
            $table->string('province_id')->nullable();
            $table->string('district_id')->nullable();
            $table->string('electorate_id')->nullable();
            $table->string('sub_district_id')->nullable();
            $table->string('political_partie_id')->nullable();
            $table->string('year_id')->nullable();
            $table->string('type')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('candidates');
    }
}
