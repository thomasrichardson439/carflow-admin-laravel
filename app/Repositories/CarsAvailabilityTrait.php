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
     * @param Collection $availabilitySlots
     * @param Carbon $dateFrom
     * @param Carbon $dateTo
     * @param $bookedHours - car_id -> date -> hours formatted array
     * @return array
     */
    public function availabilityCalendar(Collection $availabilitySlots, Carbon $dateFrom, Carbon $dateTo, array $bookedHours) : array
    {
        $calendar = [];
        $slots = [];

        foreach ($availabilitySlots as $slot) {
            switch ($slot->availability_type) {
                case CarAvailabilitySlot::TYPE_RECURRING:
                    $slots[$slot->car_id][$slot->available_at_recurring][] = $slot;
                    break;

                case CarAvailabilitySlot::TYPE_ONE_TIME:
                    $slots[$slot->car_id][$slot->available_at][] = $slot;
                    break;
            }
        }

        $date = clone $dateFrom;

        for (; $date->timestamp <= $dateTo->timestamp; $date->addDay()) {

            $dateFormatted = $date->format('Y-m-d');
            $dayOfWeek = strtolower($date->format('l'));

            foreach ($slots as $carId => $slotModels) {

                $calendar[$carId][$dateFormatted] = [];

                if (isset($slotModels[$dayOfWeek])) {
                    $calendar[$carId][$dateFormatted] = array_merge(
                        $calendar[$carId][$dateFormatted],
                        $this->extractHoursFromSlots($slotModels[$dayOfWeek])
                    );
                }

                if (isset($slotModels[$dateFormatted])) {
                    $calendar[$carId][$dateFormatted] = array_merge($calendar[$carId][$dateFormatted],
                        $this->extractHoursFromSlots($slotModels[$dateFormatted])
                    );
                }

                $calendar[$carId][$dateFormatted] = array_unique($calendar[$carId][$dateFormatted]);

                if (isset($bookedHours[$carId][$dateFormatted])) {
                    $calendar[$carId][$dateFormatted] = array_values(
                        array_diff(
                            $calendar[$carId][$dateFormatted],
                            $bookedHours[$carId][$dateFormatted]
                        )
                    );
                }

                /**
                 * Remove hours at the beginning day which are outside searched interval
                 */
                if ($date->dayOfYear == $dateFrom->dayOfYear) {
                    $calendar[$carId][$dateFormatted] = array_values(array_filter(
                        $calendar[$carId][$dateFormatted],
                        function($hour) use ($dateFrom) {
                            return $hour >= $dateFrom->hour;
                        }
                    ));
                }

                /**
                 * Remove hours at the end day which are outside searched interval
                 */
                if ($date->dayOfYear == $dateTo->dayOfYear) {
                    $calendar[$carId][$dateFormatted] = array_values(array_filter(
                        $calendar[$carId][$dateFormatted],
                        function($hour) use ($dateTo) {
                            return $hour <= $dateTo->hour;
                        }
                    ));
                }
            }
        }

        return $calendar;
    }

    /**
     * Allows to build calendar of bookings for comparing to availability
     * @param array|int $carIds
     * @param Carbon $from
     * @param Carbon $to
     * @return array
     */
    public function bookingCalendar($carIds, Carbon $from, Carbon $to) : array
    {
        $carIds = (array)$carIds;

        $bookings = Booking::query()
            ->whereIn('car_id', $carIds)
            ->where('status', '!=', Booking::STATUS_CANCELED)
            ->where(function(Builder $query) use ($from, $to) {

                $query->where('booking_starting_at', '>=', $from)
                      ->where('booking_ending_at', '<=', $to);

                $query->orWhere('is_recurring', 1);
            })
            ->get();

        $recurlyBookings = [];

        /**
         * Process recurred bookings to array [day of week] => [car id] => [hours]
         */
        foreach ($bookings as $booking) {
            if (!$booking->is_recurring) {
                continue;
            }

            /**
             * @var Carbon $walkThroughDate
             */
            $walkThroughDate = clone $booking->booking_starting_at;

            while ($walkThroughDate->lessThan($booking->booking_ending_at)) {

                $recurlyBookings[$walkThroughDate->format('l')][$booking->car_id][] = (int)$walkThroughDate->format('H');
                $walkThroughDate->addHour();
            }
        }

        $results = [];

        /**
         * Process one-time bookings to array [car id] => [day of week] => [hours]
         */
        foreach ($bookings as $booking) {

            if ($booking->is_recurring) {
                continue;
            }

            /**
             * @var Carbon $walkThroughDate
             */
            $walkThroughDate = clone $booking->booking_starting_at;

            while ($walkThroughDate->lessThan($booking->booking_ending_at)) {

                $ymd = $walkThroughDate->format('Y-m-d');

                $results[$booking->car_id][$ymd][] = (int)$walkThroughDate->format('H');
                $walkThroughDate->addHour();
            }
        }

        /**
         * Merge recurring bookings with one-time into resulting calendar
         */
        $walkThroughDate = clone $from;

        while ($walkThroughDate->lessThan($to)) {

            $ymd = $walkThroughDate->format('Y-m-d');
            $weekDay = $walkThroughDate->format('l');

            if (isset($recurlyBookings[$weekDay])) {
                foreach ($recurlyBookings[$weekDay] as $carId => $hours) {
                    $results[$carId][$ymd] = array_merge($results[$carId][$ymd] ?? [], $hours);
                }
            }

            $walkThroughDate->addDay();
        }

        return $results;
    }

    /**
     * Check if availability is not filled with bookings
     * @param array $availability
     * @param array $booked
     * @return bool
     */
    public function checkAvailability(array $availability, array $booked)
    {
        if (empty($booked)) {
            return true;
        }

        foreach ($availability as $date => $hours) {

            if (!empty(array_diff($hours, $booked[$date] ?? []))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Allows to find ids of cars which has at least one available hour within picked interval
     * @param Carbon $from
     * @param Carbon $to
     * @return array
     */
    public function findCarsAvailableBetweenDates(Carbon $from, Carbon $to)
    {
        $walkerDate = clone $from;

        $daysOfWeek = [];
        $dates = [];

        for (;$walkerDate->timestamp <= $to->timestamp; $walkerDate->addHour()) {
            $daysOfWeek[$walkerDate->format('Y-m-d')] = strtolower($walkerDate->format('l'));
            $dates[] = $walkerDate->format('Y-m-d');
        }

        $availability = CarAvailabilitySlot::query()
            ->whereIn('available_at_recurring', $daysOfWeek)
            ->orWhere(function(Builder $query) use ($dates) {
                $query->whereIn('available_at', $dates);
            })
            ->get();

        $booked = $this->bookingCalendar($availability->pluck('car_id')->toArray(), $from, $to);
        $available = $this->availabilityCalendar($availability, $from, $to, $booked);

        $filteredCarIds = [];

        foreach ($available as $carId => $dates) {
            if ($this->checkAvailability($dates, $booked[$carId] ?? [])) {
                $filteredCarIds[] = $carId;
            }
        }

        return $filteredCarIds;
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

        $query->whereIn('id', $this->findCarsAvailableBetweenDates($availableFrom, $availableTo));

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
        $cars = $query->get();

        foreach ($cars as $car) {

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