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
        $factory = factory(\App\Models\Car::class);

        $factory->create([
            'image_s3_url' => 'https://hips.hearstapps.com/amv-prod-cad-assets.s3.amazonaws.com/media/assets/submodel/7800.jpg',
            'model' => 'Prius',
        ]);

        $factory->create([
            'image_s3_url' => 'https://article.images.consumerreports.org/prod/content/dam/CRO%20Images%202018/Cars/March/CR-Cars-InlineHero-2018-Honda-CR-V-driving-3-18',
            'model' => 'Accent',
        ]);

        $factory->create([
            'image_s3_url' => 'https://www.enterprise.ca/content/dam/global-vehicle-images/cars/CHEV_MALI_2016.png',
            'model' => 'Nubia',
        ]);

        $factory->create([
            'image_s3_url' => 'https://crdms.images.consumerreports.org/prod/cars/cr/car-groups/103-11352',
            'model' => 'SX10',
        ]);

        $factory->create([
            'image_s3_url' => 'http://cdn.motorpage.ru/Photos/800/4f7af586c1aee.jpg',
            'model' => '5',
        ]);

        $factory = factory(\App\Models\CarAvailabilitySlot::class);

        $day = now();

        for ($i = 1; $i <= 7; $i++) {

            $day->subDay();

            for ($id = 1; $id <= 5; $id++) {
                $factory->create([
                    'car_id' => $id,
                    'availability_type' => \App\Models\CarAvailabilitySlot::TYPE_RECURRING,
                    'available_at' => null,
                    'available_at_recurring' => strtolower($day->format('l')),
                    'available_hour_from' => $day->setTime(rand(6, 10), 0, 0)->format('H:i:s'),
                    'available_hour_to' => $day->setTime(rand(11, 22), 59, 0)->format('H:i:s'),
                ]);
            }
        }
    }
}
