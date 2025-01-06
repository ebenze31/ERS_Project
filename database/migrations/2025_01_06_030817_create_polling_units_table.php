<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePollingUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polling_units', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name_polling_unit')->nullable();
            $table->string('province_id')->nullable();
            $table->string('district_id')->nullable();
            $table->string('electorate_id')->nullable();
            $table->string('sub_district_id')->nullable();
            $table->string('eligible_voters')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('polling_units');
    }
}
