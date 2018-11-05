<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Models\Car;
use App\Models\CarCategory;
use App\Models\CarManufacturer;
use Carbon\Carbon;

class CarsRepository extends BaseRepository
{
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
     * Allows to fetch formatted list of available for booking cars
     * @param array $filters
     * @return array
     */
    public function availableForBooking(array $filters) : array
    {
        $query = $this->model
            ->query()
            ->orderBy('booking_available_from', 'DESC');

        $query->whereNotIn('id', Booking::query()
            ->select('car_id')
            ->whereBetween(
                'booking_starting_at',
                [$filters['available_from'], $filters['available_to']]
            )
            ->orWhereBetween(
                'booking_ending_at',
                [$filters['available_from'], $filters['available_to']]
            )
        );

        if (isset($filters['categories'])) {
            $query->whereIn('category_id', $filters['categories']);
        }

        if (isset($filters['allowed_recurring'])) {
            $query->where('allowed_recurring', $filters['allowed_recurring']);
        }

        if (!empty($filters['pickup_location_lat'])) {

            $diff = 'geoDiffBetweenDotsInMeters(
                pickup_location_lat, 
                pickup_location_lon,
                ' . floatval($filters['pickup_location_lat']) . ',
                ' . floatval($filters['pickup_location_lon']) . '
                 
            )';

            $query->whereRaw($diff . ' <' . ($filters['allowed_range_miles'] * self::METERS_IN_MILE))
                  ->orderBy(\DB::raw($diff), 'ASC');
        }

        $now = Carbon::now();
        $data = [];

        foreach ($query->get() as $car) {

            /** @var Car $car */

            $bookingStartingAt = Carbon::parse($car->booking_available_from);

            if ($bookingStartingAt->greaterThanOrEqualTo($now)) {
                $availability = 'Available now';
            } else {
                $availability = 'in ' . $bookingStartingAt->diffForHumans($now, true);
            }

            $data[] = [
                'car' => $this->show($car),
                'distance_miles' => $this->haversineGreatCircleDistance(
                    $car->pickup_location_lat, $car->pickup_location_lon,
                    $filters['pickup_location_lat'], $filters['pickup_location_lon']

                ) / self::METERS_IN_MILE,

                'availability' => $availability,
            ];
        }

        return $data;
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