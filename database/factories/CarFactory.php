<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Car::class, function (Faker $faker) {

    $date = \Carbon\Carbon::now()->addDays(10);

    return [
        'color' => $faker->colorName,
        'year' => $faker->numberBetween(2010, 2018),
        'plate' => implode('', $faker->randomElements(range('A', 'Z'), 3)) . ' ' . $faker->numberBetween(1000, 9999),
        'pickup_location' => $faker->address,
        'return_location' => $faker->address,
        'booking_starting_at' => $date->setTime($faker->numberBetween(6, 10), 00),
        'booking_ending_at' => (clone $date)->setTime($faker->numberBetween(11, 19), 00),
    ];
});
