<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Models\Car;
use App\Models\CarAvailabilitySlot;
use App\Models\CarCategory;
use App\Models\CarManufacturer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

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
     * Availability base query
     * @param Carbon $from
     * @return Builder
     */
    private function carAvailabilityQuery(Carbon $from) : Builder
    {
        return CarAvailabilitySlot::query()
            ->where(function(Builder $query) use ($from) {
                $query->where(function (Builder $query) use ($from) {
                    $query->where([
                        'availability_type' => CarAvailabilitySlot::TYPE_RECURRING,
                        'available_at_recurring' => strtolower($from->format('l')),
                    ]);
                })
                ->orWhere(function (Builder $query) use ($from) {
                    $query->where([
                        'availability_type' => CarAvailabilitySlot::TYPE_ONE_TIME,
                        'available_at' => $from->format('Y-m-d'),
                    ]);
                });
            });
    }

    /**
     * Allows to check if car is available within needed hours
     * @param int $carId
     * @param Carbon $from
     * @param Carbon $to
     * @param Collection|null $slots
     * @return bool
     */
    public function carIsAvailable(int $carId, Carbon $from, Carbon $to, $slots = null) : bool
    {
        if ($slots === null) {
            $filteredSlots = $this->carAvailabilityQuery($from)->where('car_id', $carId)->get();
        } else {
            $filteredSlots = $slots->filter(function (CarAvailabilitySlot $item) use ($carId) {
                return $item->car_id == $carId;
            });
        }

        $hours = [];

        foreach ($filteredSlots as $slot) {

            $range = range(
                strtotime($slot->available_hour_from),
                strtotime($slot->available_hour_to),
                60 * 60
            );

            foreach ($range as $hour) {
                $hours[(int)date('H', $hour)] = 1;
            }
        }

        $range = range(
            $from->timestamp,
            $to->timestamp,
            60 * 60
        );

        foreach ($range as $hour) {
            if (!isset($hours[(int)date('H', $hour)])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Allows to fetch formatted list of available for booking cars
     * @param array $filters
     * @return array
     */
    public function availableForBooking(array $filters) : array
    {
        $query = $this->model
            ->query();

        $availableFrom = Carbon::parse($filters['available_from']);
        $availableTo = Carbon::parse($filters['available_to']);

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

        $carAvailabilitySlots = $this->carAvailabilityQuery($availableFrom)->get();

        $query->whereIn('id', $carAvailabilitySlots->pluck('car_id'));

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

        $data = [];

        foreach ($query->get() as $car) {

            /** @var Car $car */

            /**
             * If car is not available for picked hours, skip it
             */
            if (!$this->carIsAvailable($car->id, $availableFrom, $availableTo, $carAvailabilitySlots)) {
                continue;
            }

            if (!empty($filters['pickup_location_lat'])) {
                $distance = $this->haversineGreatCircleDistance(
                    $car->pickup_location_lat, $car->pickup_location_lon,
                    $filters['pickup_location_lat'], $filters['pickup_location_lon']

                ) / self::METERS_IN_MILE;
            } else {
                $distance = null;
            }

            $data[] = [
                'car' => $this->show($car),
                'distance_miles' => $distance,
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