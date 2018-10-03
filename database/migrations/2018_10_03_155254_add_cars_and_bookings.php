<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCarsAndBookings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image_s3_url');
            $table->string('manufacturer');
            $table->string('model');
            $table->string('color');
            $table->integer('year');
            $table->string('plate');
            $table->string('pickup_location');
            $table->string('return_location');
            $table->timestamp('booking_starting_at')->nullable();
            $table->timestamp('booking_ending_at')->nullable();
            $table->timestamps();
        });

        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('car_id');
            $table->timestamp('booking_starting_at')->nullable();
            $table->timestamp('booking_ending_at')->nullable();
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
        Schema::dropIfExists('cars');
        Schema::dropIfExists('bookings');
    }
}
