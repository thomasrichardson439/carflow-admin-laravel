<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Booking;

class CreateBookingStartedReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_started_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('booking_id')->notNull();
            $table->string('photo_front_s3_link')->nullable();
            $table->string('photo_back_s3_link')->nullable();
            $table->string('photo_left_s3_link')->nullable();
            $table->string('photo_right_s3_link')->nullable();
            $table->string('photo_gas_tank_s3_link')->nullable();
            $table->string('photo_mileage_s3_link')->nullable();
            $table->timestamps();
        });

        foreach (Booking::where('status', Booking::STATUS_ENDED)->orWhere('status', Booking::STATUS_DRIVING)->get() as $key => $booking) {
            DB::insert('insert into booking_started_reports (booking_id, photo_mileage_s3_link, created_at, updated_at) values (?, ?, ?, ?)',
                [$booking->id, $booking->photo_start_mileage_s3_link, $booking->booking_starting_at, $booking->booking_starting_at]);
        }

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('photo_start_mileage_s3_link');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $results = DB::select('select * from booking_started_reports');

        Schema::table('bookings', function (Blueprint $table) {
            $table->string('photo_start_mileage_s3_link');
        });

        foreach ($results as $key => $bookingStartedReport) {
            DB::update('update bookings set photo_start_mileage_s3_link = "'.$bookingStartedReport->photo_mileage_s3_link.'" where id = ?', [$bookingStartedReport->booking_id]);
        }

        Schema::dropIfExists('booking_started_reports');
    }
}
