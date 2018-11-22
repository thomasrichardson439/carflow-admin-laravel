<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Car::class, function (Faker $faker) {

    $date = \Carbon\Carbon::now()->addDays(10);

    $randomPickupBorough = \App\Models\Borough::query()->inRandomOrder()->first();
    $randomReturnBorough = \App\Models\Borough::query()->inRandomOrder()->first();

    $randomCategory = \App\Models\CarCategory::query()->inRandomOrder()->first();

    $randomManufacturer = \App\Models\CarManufacturer::query()->inRandomOrder()->first();

    return [
        'color' => $faker->colorName,
        'year' => $faker->numberBetween(2010, 2018),
        'plate' => implode('', $faker->randomElements(range('A', 'Z'), 3)) . ' ' . $faker->numberBetween(1000, 9999),
        'full_pickup_location' => $faker->address,
        'full_return_location' => $faker->address,
        'pickup_borough_id' => $randomPickupBorough->id,
        'return_borough_id' => $randomReturnBorough->id,
        'category_id' => $randomCategory->id,
        'manufacturer_id' => $randomManufacturer->id,
        'pickup_location_lat' => $faker->numberBetween(33000, 35000) / 1000,
        'pickup_location_lon' => -1 * $faker->numberBetween(104000, 108000) / 1000,
        'return_location_lat' => $faker->numberBetween(33000, 35000) / 1000,
        'return_location_lon' => -1 * $faker->numberBetween(104000, 108000) / 1000,
        'allowed_recurring' => rand(0, 1),
        'owner' => 'Car Flo',
        'seats' => rand(2, 7),
        'policy_number' => 'SN' . rand(10000, 99999) . rand(10000, 99999),
    ];
});

$factory->define(App\Models\CarAvailabilitySlot::class, function (Faker $faker) {
    return [];
});