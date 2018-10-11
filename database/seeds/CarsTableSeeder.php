<?php

use Illuminate\Database\Seeder;

class CarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Car::query()->truncate();

        \App\Models\Booking::query()->truncate();

        factory(\App\Models\Car::class)->create([
            'image_s3_url' => 'https://hips.hearstapps.com/amv-prod-cad-assets.s3.amazonaws.com/media/assets/submodel/7800.jpg',
            'manufacturer' => 'Toyota',
            'model' => 'Prius',
        ]);

        factory(\App\Models\Car::class)->create([
            'image_s3_url' => 'https://article.images.consumerreports.org/prod/content/dam/CRO%20Images%202018/Cars/March/CR-Cars-InlineHero-2018-Honda-CR-V-driving-3-18',
            'manufacturer' => 'Hundai',
            'model' => 'Accent',
        ]);

        factory(\App\Models\Car::class)->create([
            'image_s3_url' => 'https://www.enterprise.ca/content/dam/global-vehicle-images/cars/CHEV_MALI_2016.png',
            'manufacturer' => 'Chevrolet',
            'model' => 'Nubia',
        ]);
    }
}
