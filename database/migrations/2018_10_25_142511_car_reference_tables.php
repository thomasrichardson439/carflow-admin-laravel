<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CarReferenceTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boroughs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->notNull();
            $table->timestamps();
        });

        Schema::create('car_manufacturers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->notNull();
            $table->timestamps();
        });

        Schema::create('car_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->notNull();
            $table->timestamps();
        });

        DB::insert('
            INSERT INTO car_manufacturers (name) SELECT DISTINCT manufacturer FROM cars
        ');

        DB::insert('
            INSERT INTO boroughs (name) SELECT DISTINCT short_pickup_location FROM cars
        ');

        DB::insert('
            INSERT INTO boroughs (name) SELECT DISTINCT short_return_location FROM cars
        ');

        DB::insert('INSERT INTO car_categories SET name = "Sedan"');

        Schema::table('cars', function (Blueprint $table) {
            $table->integer('manufacturer_id')->nullable();
            $table->integer('pickup_borough_id')->nullable();
            $table->integer('return_borough_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->boolean('allowed_recurring')->nullable();
        });

        DB::statement('
            UPDATE cars SET 
                manufacturer_id = (SELECT id FROM car_manufacturers WHERE name = cars.manufacturer),
                pickup_borough_id = (SELECT id FROM boroughs WHERE name = cars.short_pickup_location),
                return_borough_id = (SELECT id FROM boroughs WHERE name = cars.short_return_location),
                allowed_recurring = false,
                category_id = 1 
        ');

        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn('manufacturer');
            $table->dropColumn('short_pickup_location');
            $table->dropColumn('short_return_location');

            $table->integer('manufacturer_id')->notNull()->change();
            $table->integer('pickup_borough_id')->notNull()->change();
            $table->integer('return_borough_id')->notNull()->change();
            $table->integer('category_id')->notNull()->change();
            $table->boolean('allowed_recurring')->notNull()->change();
        });

        Schema::table('bookings', function (Blueprint $table) {
           $table->boolean('is_recurring')->notNull()->defaultValue(false);
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
            $table->string('manufacturer');
            $table->string('short_pickup_location');
            $table->string('short_return_location');
        });

        DB::statement('UPDATE cars SET 
            manufacturer = (SELECT name FROM car_manufacturers WHERE id = cars.manufacturer_id),
            short_pickup_location = (SELECT name FROM boroughs WHERE id = cars.pickup_borough_id),
            short_return_location = (SELECT name FROM boroughs WHERE id = cars.return_borough_id)
        ');

        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn('manufacturer_id');
            $table->dropColumn('pickup_borough_id');
            $table->dropColumn('return_borough_id');
            $table->dropColumn('category_id');
            $table->dropColumn('allowed_recurring');
        });

        Schema::dropIfExists('boroughs');
        Schema::dropIfExists('car_manufacturers');
        Schema::dropIfExists('car_categories');

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('is_recurring');
        });
    }
}
