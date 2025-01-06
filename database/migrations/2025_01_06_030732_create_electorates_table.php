<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateElectoratesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('electorates', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name_electorate')->nullable();
            $table->string('province_id')->nullable();
            $table->string('district_id')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('electorates');
    }
}
