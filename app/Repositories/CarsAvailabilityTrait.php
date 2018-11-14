<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use App\Models\CarAvailabilitySlot;
use App\Models\Booking;
use App\Models\Car;
use Illuminate\Database\Eloquent\Collection;

/**
 * Trait CarsAvailabilityTrait
 * @package App\Repositories
 *
 * @mixin CarsRepository
 */
trait CarsAvailabilityTrait
{
    /**
     * Allows to check if car is available within needed hours
     * It also sticks together intervals which has no breaks between
     * @param int $carId
     * @param Carbon $from
     * @param Carbon $to
     * @return bool
     */
    public function carIsAvailable(int $carId, Carbon $from, Carbon $to) : bool
    {
        $fromSlotsHours = array_flip(
            $this->extractHoursFromSlots(
                $this->carAvailabilityQuery($from)->where('car_id', $carId)->get()
            )
        );

        $toSlotsHours = null;

        if ($from->dayOfYear != $to->dayOfYear) {
            $toSlotsHours = array_flip(
                $this->extractHoursFromSlots(
                    $this->carAvailabilityQuery($to)->where('car_id', $carId)->get()
                )
            );
        }

        $walkerDate = clone $from;
        $activeHours = $fromSlotsHours;

        for (;$walkerDate->timestamp <= $to->timestamp; $walkerDate->addHour()) {

            if (!isset($activeHours[$walkerDate->hour])) {
                return false;
            }

            /**
             * Switch active slots to next day (to)
             */
            if ($walkerDate->hour == 23) {
                $activeHours = $toSlotsHours;
            }
        }

        return true;
    }


    /**
     * Checks which cars are inside selected range
     * @param Carbon $from
     * @return Builder
     */
    private function carAvailabilityQuery(Carbon $checkDate) : Builder
    {
        return CarAvailabilitySlot::query()
            ->where(function(Builder $query) use ($checkDate) {
                $query->where(function (Builder $query) use ($checkDate) {
                    $query->where([
                        'availability_type' => CarAvailabilitySlot::TYPE_RECURRING,
                        'available_at_recurring' => strtolower($checkDate->format('l')),
                    ]);
                })
                ->orWhere(function (Builder $query) use ($checkDate) {
                    $query->where([
                        'availability_type' => CarAvailabilitySlot::TYPE_ONE_TIME,
                        'available_at' => $checkDate->format('Y-m-d'),
                    ]);
                });
            });
    }

    /**
     * Check which cars are inside selected range with hours range checking
     * @param Carbon $checkDate
     * @return Builder
     */
    private function carAvailabilityQueryWithHours(Carbon $checkDate) : Builder
    {
        return $this->carAvailabilityQuery($checkDate)
            ->select('car_id')
            ->where('available_hour_from', '<=', $checkDate->format('H:i:s'))
            ->where('available_hour_to', '>=', $checkDate->format('H:i:s'));
    }

    /**
     * Allows to extract array of available hours from slots
     * @param array|\Iterator $slots
     * @return array
     */
    private function extractHoursFromSlots($slots) : array
    {
        $out = [];

        foreach ($slots as $slot) {
            $range = range(
                strtotime($slot->available_hour_from),
                strtotime($slot->available_hour_to),
                60 * 60
            );

            foreach ($range as $timestamp) {
                $out[] = (int)date('H', $timestamp);
            }
        }

        return $out;
    }

    /**
     * Allows to build availability calendar
     * @param Car $car
     * @param Carbon $dateFrom
     * @param Carbon $dateTo
     * @param $bookedHours - date -> hours formatted array
     * @return array
     */
    public function availabilityCalendar(Car $car, Carbon $dateFrom, Carbon $dateTo, array $bookedHours) : array
    {
        $calendar = [];
        $slots = [];

        foreach ($car->availabilitySlots as $slot) {
            switch ($slot->availability_type) {
                case CarAvailabilitySlot::TYPE_RECURRING:
                    $slots[$slot->available_at_recurring][] = $slot;
                    break;

                case CarAvailabilitySlot::TYPE_ONE_TIME:
                    $slots[$slot->available_at][] = $slot;
                    break;
            }
        }

        $date = clone $dateFrom;

        for (; $date->dayOfYear != ($dateTo->dayOfYear + 1); $date->addDay()) {

            $key = $date->format('Y-m-d');

            $calendar[$key] = [];

            if (isset($slots[strtolower($date->format('l'))])) {
                $calendar[$key] = array_merge($calendar[$key],
                    $this->extractHoursFromSlots($slots[strtolower($date->format('l'))])
                );
            }

            if (isset($slots[$date->format('Y-m-d')])) {
                $calendar[$key] = array_merge($calendar[$key],
                    $this->extractHoursFromSlots($slots[$date->format('Y-m-d')])
                );
            }

            $calendar[$key] = array_unique($calendar[$key]);

            if (isset($bookedHours[$key])) {
                $calendar[$key] = array_values(array_diff($calendar[$key], $bookedHours[$key]));
            }
        }

        return $calendar;
    }

    /**
     * Allows to fetch formatted list of available for booking cars
     * @param array $filters
     * @return array
     */
    public function availableForBooking(array $filters) : array
    {
        $query = $this->model->query();

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

        $query->whereIn('id', $this->carAvailabilityQueryWithHours($availableFrom))
              ->whereIn('id', $this->carAvailabilityQueryWithHours($availableTo));

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
}