<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $models = [
            \App\Models\BookingEndedReport::class,
            \App\Models\BookingIssueReport::class,
            \App\Models\BookingReceipt::class,
            \App\Models\Booking::class,

            \App\Models\Car::class,

            \App\Models\Borough::class,
            \App\Models\CarCategory::class,
            \App\Models\CarManufacturer::class,
        ];

        foreach ($models as $model) {
            $model::query()->truncate();
        }

        $this->call(UsersTableSeeder::class);

        $this->call(DictionariesSeeder::class);
        $this->call(CarsTableSeeder::class);
    }
}
