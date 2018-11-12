<?php

use Illuminate\Database\Seeder;

class DictionariesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->addBoroughs();
        $this->addCarCategories();
        $this->addCarManufacturers();
    }

    private function addCarManufacturers()
    {
        $factory = factory(\App\Models\CarManufacturer::class);

        $names = [
            'ACURA',
            'ALFA ROMEO',
            'AM GENERAL',
            'AMERICAN IRONHORSE',
            'AMERICAN LAFRANCE',
            'APRILIA',
            'ARCTIC CAT',
            'ARGO',
            'ASTON MARTIN',
            'ATK',
            'AUDI',
            'AUTOCAR LLC.',
            'AVANTI',
            'BENTLEY',
            'BERTONE',
            'BETA',
            'BIG DOG',
            'BIMOTA',
            'BLUE BIRD',
            'BMW',
            'BOBCAT',
            'BOMBARDIER',
            'BUELL',
            'BUGATTI',
            'BUICK',
            'CADILLAC',
            'CAN-AM',
            'CANNONDALE',
            'CHANCE COACH TRANSIT BUS',
            'CHEVROLET',
            'CHRYSLER',
            'COBRA',
            'CODA',
            'COUNTRY COACH MOTORHOME',
            'CRANE CARRIER',
            'CUB CADET',
            'DAEWOO',
            'DODGE',
            'DUCATI',
            'E-TON',
            'EL DORADO',
            'FERRARI',
            'FIAT',
            'FISKER',
            'FORD',
            'FREIGHTLINER',
            'GAS GAS',
            'GILLIG',
            'GMC',
            'HARLEY DAVIDSON',
            'HINO',
            'HM',
            'HONDA',
            'HUMMER',
            'HUSABERG',
            'HUSQVARNA',
            'HYOSUNG',
            'HYUNDAI',
            'IC CORPORATION',
            'INDIAN',
            'INFINITI',
            'INTERNATIONAL',
            'ISUZU',
            'JAGUAR',
            'JEEP',
            'JOHN DEERE',
            'KASEA',
            'KAWASAKI',
            'KENWORTH',
            'KIA',
            'KTM',
            'KUBOTA',
            'KYMCO',
            'LAFORZA',
            'LAMBORGHINI',
            'LAND ROVER',
            'LEM',
            'LEXUS',
            'LINCOLN',
            'LOTUS',
            'MACK',
            'MASERATI',
            'MAYBACH',
            'MAZDA',
            'MCLAREN',
            'MERCEDES-BENZ',
            'MERCURY',
            'MINI',
            'MITSUBISHI',
            'MITSUBISHI FUSO',
            'MORGAN',
            'MOTO GUZZI',
            'MOTOR COACH INDUSTRIES',
            'MV AGUSTA',
            'NASH',
            'NEW FLYER',
            'NISSAN',
            'NOVA BUS CORPORATION',
            'OLDSMOBILE',
            'ORION BUS',
            'OSHKOSH MOTOR TRUCK CO.',
            'OTTAWA',
            'PANOZ',
            'PETERBILT',
            'PEUGEOT',
            'PIAGGIO',
            'PIERCE MFG. INC.',
            'PLYMOUTH',
            'POLARIS',
            'PONTIAC',
            'PORSCHE',
            'QVALE',
            'RAM',
            'RENAULT',
            'ROLLS ROYCE',
            'ROVER',
            'SAAB',
            'SALEEN',
            'SATURN',
            'SCION',
            'SEA-DOO',
            'SEAT',
            'SKI-DOO',
            'SMART',
            'SRT',
            'STERLING',
            'STERLING TRUCK',
            'SUBARU',
            'SUZUKI',
            'TESLA',
            'TM',
            'TOYOTA',
            'TRIUMPH',
            'UD',
            'VENTO',
            'VESPA',
            'VICTORY',
            'VOLKSWAGEN',
            'VOLVO',
            'VPG',
            'WESTERN RV',
            'WESTERN STAR',
            'WORKHORSE',
            'YAMAHA',
        ];

        foreach ($names as $name) {
            $factory->create([
                'name' => ucfirst(strtolower($name)),
            ]);
        }
    }

    private function addCarCategories()
    {
        $factory = factory(\App\Models\CarCategory::class);

        $names = [
            'Sedan',
            'SUV',
            'Coupe',
            'Wagon',
            'Roadster',
            'Minivan',
            'Pickup',
            'Mini',
        ];

        foreach ($names as $name) {
            $factory->create([
                'name' => $name,
            ]);
        }
    }

    private function addBoroughs()
    {
        $factory = factory(\App\Models\Borough::class);

        $names = [
            'Manhattan',
            'Brooklyn',
            'Queens',
            'Bronx',
            'Staten Island',
        ];

        foreach ($names as $name) {
            $factory->create([
                'name' => $name,
            ]);
        }
    }
}
