<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCarAvailability extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->renameColumn('booking_starting_at', 'booking_available_from');
            $table->renameColumn('booking_ending_at', 'booking_available_to');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->renameColumn('booking_available_from', 'booking_starting_at');
            $table->renameColumn('booking_available_to', 'booking_ending_at');
        });
    }
}
