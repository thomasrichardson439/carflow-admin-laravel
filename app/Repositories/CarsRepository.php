<?php

namespace App\Repositories;

use App\Models\Car;
use App\Models\CarCategory;
use App\Models\CarManufacturer;

class CarsRepository extends BaseRepository
{
    use CarsAvailabilityTrait;

    const METERS_IN_MILE = 1609.34;
    const EARTH_RADIUS = 6371000;

    /**
     * @var Car
     */
    protected $model;

    public function __construct()
    {
        $this->model = new Car();
    }

    /**
     * Allows to get ordered list of categories
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function categories()
    {
        return CarCategory::query()->orderBy('name', 'ASC')->get();
    }

    /**
     * Allows to get ordered list of manufacturers
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function manufacturers()
    {
        return CarManufacturer::query()->orderBy('name', 'ASC')->get();
    }

    /**
     * Allows to calculate distance between points
     * @param float $latitudeFrom
     * @param float $longitudeFrom
     * @param float $latitudeTo
     * @param float $longitudeTo
     * @return float
     */
    private function haversineGreatCircleDistance(
        $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * self::EARTH_RADIUS;
    }
}