<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhoneToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_1')->nullable();
            $table->string('phone_2')->nullable();
            $table->string('province_id')->nullable();
            $table->string('district_id')->nullable();
            $table->string('electorate_id')->nullable();
            $table->string('sub_district_id')->nullable();
            $table->string('polling_unit_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
