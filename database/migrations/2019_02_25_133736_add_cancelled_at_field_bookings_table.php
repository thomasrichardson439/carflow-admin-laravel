<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCancelledAtFieldBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->timestamp('cancelled_at')
                ->default('2000-01-01 00:00:00') //TODO how to use it with INVALID_DATE 0000-00-00 00:00:00
                ->after('updated_at');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropUnique('car_unique_index');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->unique(['car_id', 'booking_starting_at', 'cancelled_at'], 'car_unique_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('cancelled_at');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropUnique('car_unique_index');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->unique(['car_id', 'booking_starting_at'], 'car_unique_index');
        });
    }
}
