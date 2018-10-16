<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRideTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('late_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('booking_id')->notNull();
            $table->integer('delay_minutes')->notNull();
            $table->string('photo_s3_link')->notNull();
            $table->string('reason', 1000)->notNull();
            $table->timestamps();
        });

        Schema::create('booking_ended_reports', function (Blueprint $table) {
            $table->integer('booking_id')->notNull();
            $table->string('photo_front_s3_link')->notNull();
            $table->string('photo_back_s3_link')->notNull();
            $table->string('photo_left_s3_link')->notNull();
            $table->string('photo_right_s3_link')->notNull();
            $table->string('photo_gas_tank_s3_link')->notNull();
            $table->string('notes', 1000)->nullable();
            $table->timestamps();
            $table->primary('booking_id');
        });


        Schema::create('booking_issue_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('booking_id')->notNull();
            $table->enum('report_type', ['damage', 'malfunction'])->notNull();
            $table->string('photo_1_s3_link')->nullable();
            $table->string('photo_2_s3_link')->nullable();
            $table->string('photo_3_s3_link')->nullable();
            $table->string('photo_4_s3_link')->nullable();
            $table->string('description', 1000)->notNull();
            $table->string('license_plate')->nullable();
            $table->timestamps();
        });

        Schema::create('booking_receipts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('booking_id')->notNull();
            $table->string('title')->notNull();
            $table->string('description', 1000)->notNull();
            $table->decimal('price', 7, 2)->notNull();
            $table->date('receipt_date')->notNull();
            $table->string('photo_s3_link')->notNull();
            $table->timestamps();
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->enum('status', ['pending', 'driving', 'ended', 'canceled'])->notNull()->default('pending');
        });

        Schema::table('cars', function (Blueprint $table) {

            $table->string('short_pickup_location')->null();
            $table->renameColumn('pickup_location', 'full_pickup_location');

            $table->string('short_return_location')->null();
            $table->renameColumn('return_location', 'full_return_location');

            $table->decimal('pickup_location_lat', 10, 6)->null();
            $table->decimal('pickup_location_lon', 10, 6)->null();
            $table->decimal('return_location_lat', 10, 6)->null();
            $table->decimal('return_location_lon', 10, 6)->null();
        });

        DB::statement("UPDATE cars SET 
            short_pickup_location = 'Test', 
            short_return_location = 'Test',
            pickup_location_lat = 0,
            pickup_location_lon = 0,
            return_location_lat = 0,
            return_location_lon = 0
        ");

        Schema::table('cars', function (Blueprint $table) {
            $table->string('short_pickup_location')->notNull()->change();
            $table->string('short_return_location')->notNull()->change();
            $table->decimal('pickup_location_lat', 10, 6)->notNull()->change();
            $table->decimal('pickup_location_lon', 10, 6)->notNull()->change();
            $table->decimal('return_location_lat', 10, 6)->notNull()->change();
            $table->decimal('return_location_lon', 10, 6)->notNull()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('late_notifications');
        Schema::dropIfExists('booking_ended_reports');
        Schema::dropIfExists('booking_issue_reports');
        Schema::dropIfExists('booking_receipts');

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn([
                'short_pickup_location',
                'short_return_location',
                'pickup_location_lat',
                'pickup_location_lon',
                'return_location_lat',
                'return_location_lon',
            ]);

            $table->renameColumn('full_pickup_location', 'pickup_location');
            $table->renameColumn('full_return_location', 'return_location');
        });
    }
}
