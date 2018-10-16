<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Car::class, function (Faker $faker) {

    $date = \Carbon\Carbon::now()->addDays(10);

    return [
        'color' => $faker->colorName,
        'year' => $faker->numberBetween(2010, 2018),
        'plate' => implode('', $faker->randomElements(range('A', 'Z'), 3)) . ' ' . $faker->numberBetween(1000, 9999),
        'full_pickup_location' => $faker->address,
        'full_return_location' => $faker->address,
        'short_pickup_location' => 'New York',
        'short_return_location' => 'Bronx',
        'booking_available_from' => $date->setTime($faker->numberBetween(6, 10), 00),
        'booking_available_to' => (clone $date)->setTime($faker->numberBetween(11, 19), 59, 59),
        'pickup_location_lat' => $faker->numberBetween(33000, 35000) / 1000,
        'pickup_location_lon' => -1 * $faker->numberBetween(104000, 108000) / 1000,
        'return_location_lat' => $faker->numberBetween(33000, 35000) / 1000,
        'return_location_lon' => -1 * $faker->numberBetween(104000, 108000) / 1000,
    ];
});
