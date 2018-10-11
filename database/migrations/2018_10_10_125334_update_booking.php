<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE cars MODIFY booking_starting_at TIME NOT NULL');

        DB::statement('ALTER TABLE cars MODIFY booking_ending_at TIME NOT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE cars MODIFY booking_starting_at TIMESTAMP NULL DEFAULT NULL');

        DB::statement('ALTER TABLE cars MODIFY booking_ending_at TIMESTAMP NULL DEFAULT NULL');
    }
}
