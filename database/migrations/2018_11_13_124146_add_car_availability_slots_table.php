<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCarAvailabilitySlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_availability_slots', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('car_id');
            $table->enum('availability_type', ['recurring','one-time']);
            $table->date('available_at')->nullable();
            $table->enum('available_at_recurring', [
                'monday',
                'tuesday',
                'wednesday',
                'thursday',
                'friday',
                'saturday',
                'sunday',
            ])->nullable();
            $table->time('available_hour_from');
            $table->time('available_hour_to');              
        });

        Schema::table('cars', function(Blueprint $table) {
            $table->dropColumn('booking_available_from');
            $table->dropColumn('booking_available_to');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_availability_slots');

        Schema::table('cars', function(Blueprint $table) {
            $table->time('booking_available_from')->notNull()->default('10:00:00');
            $table->time('booking_available_to')->notNull()->default('23:00:00');
        });
    }
}
