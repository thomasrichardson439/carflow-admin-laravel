<?php

$factory->define(App\Models\Borough::class, function () {
    return [
        'created_at' => now(),
        'updated_at' => null,
    ];
});

$factory->define(App\Models\CarCategory::class, function () {
    return [
        'created_at' => now(),
        'updated_at' => null,
    ];
});

$factory->define(App\Models\CarManufacturer::class, function () {
    return [
        'created_at' => now(),
        'updated_at' => null,
    ];
});