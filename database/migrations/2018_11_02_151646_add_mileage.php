<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMileage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('photo_start_mileage_s3_link')->nullable();
        });

        Schema::table('booking_ended_reports', function (Blueprint $table) {
            $table->string('photo_mileage_s3_link')->nullable();
        });

        DB::statement("UPDATE booking_ended_reports SET photo_mileage_s3_link = ''");

        Schema::table('booking_ended_reports', function (Blueprint $table) {
            $table->string('photo_mileage_s3_link')->notNull()->change();
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
            $table->dropColumn('photo_start_mileage_s3_link');
        });

        Schema::table('booking_ended_reports', function (Blueprint $table) {
            $table->dropColumn('photo_mileage_s3_link');
        });
    }
}
