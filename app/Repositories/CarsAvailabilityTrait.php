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
     * Updates car availabilities
     * @param int $carId
     * @param array $recurring
     * @param array $onetime
     * @param array $deleted
     */
    public function updateAvailabilities(int $carId, array $recurring, array $onetime, array $deleted)
    {
        foreach ($recurring as $id => $slot) {
            if ($id < 0) {
                $model = new CarAvailabilitySlot();
                $model->fill([
                    'car_id' => $carId,
                    'availability_type' => CarAvailabilitySlot::TYPE_RECURRING,
                ]);

            } else {
                $model = CarAvailabilitySlot::query()->where('id', $id)->firstOrFail();
            }

            $model->fill([
                'available_at_recurring' => $slot['day'],
                'available_hour_from' => $slot['hour_from'] . ':00',
                'available_hour_to' => $slot['hour_to'] . ':00',
            ]);

            $model->save();
        }

        foreach ($onetime as $id => $slot) {
            if ($id < 0) {
                $model = new CarAvailabilitySlot();
                $model->fill([
                    'car_id' => $carId,
                    'availability_type' => CarAvailabilitySlot::TYPE_ONE_TIME,
                ]);

            } else {
                $model = CarAvailabilitySlot::query()->where('id', $id)->firstOrFail();
            }

            $model->fill([
                'available_at' => Carbon::parse($slot['date']),
                'available_hour_from' => $slot['hour_from'] . ':00',
                'available_hour_to' => $slot['hour_to'] . ':00',
            ]);

            $model->save();
        }

        CarAvailabilitySlot::query()
            ->whereIn('id', $deleted)
            ->where('car_id', $carId)
            ->delete();
    }

    /**
     * Preparing availability view for admin
     * @param Car $car
     * @return array
     */
    public function prepareAvailabilityView(Car $car)
    {
        $availability = [
            'recurring' => [],
            'onetime' => [],
        ];

        foreach ($car->availabilitySlots as $slot) {
            $result = [
                'id' => $slot->id,
                'hour_from' => Carbon::parse($slot->available_hour_from)->hour,
                'hour_to' => Carbon::parse($slot->available_hour_to)->hour,
            ];

            switch ($slot->availability_type) {
                case CarAvailabilitySlot::TYPE_RECURRING:
                    $result['day'] = $slot->available_at_recurring;
                    $availability['recurring'][] = $result;
                    break;

                case CarAvailabilitySlot::TYPE_ONE_TIME:
                    $result['date'] = $slot->available_at->format('m/d/Y');
                    $availability['onetime'][] = $result;
                    break;
            }
        }

        return $availability;
    }

    /**
     * Allows to check if slots intersects
     * @param array $slots
     * @return bool
     */
    private function hoursAreIntersect(array $slots)
    {
        if (count($slots) == 1) {
            false;
        }

        $tmp = [];

        foreach ($slots as $slot) {
            $tmp = array_merge($tmp, $slot);
        }

        $unique = array_unique($tmp);

        return count($unique) != count($tmp);
    }

    /**
     * Validates availability list
     * @return bool
     */
    public function validateAvailabilityList(array $recurring, array $onetime) : bool
    {
        $tmp = [];

        foreach ($recurring as $slot) {
            $tmp[$slot['day']][] = range($slot['hour_from'], $slot['hour_to']);
        }

        foreach ($onetime as $slot) {

            $key = strtolower(Carbon::parse($slot['date'])->format('l'));

            $tmp[$key][] = range($slot['hour_from'], $slot['hour_to']);
        }

        foreach ($tmp as $hourSlots) {

            if (count($hourSlots) == 1) {
                continue;
            }

            if ($this->hoursAreIntersect($hourSlots)) {
                return false;
            }
        }

        return true;
    }

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
                    $slots[$slot->car_id][$slot->available_at->format('Y-m-d')][] = $slot;
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

                /**
                 * Remove booked hours from calendar
                 */
                if (isset($bookedHours[$carId][$dateFormatted])) {
                    $calendar[$carId][$dateFormatted] = array_values(
                        array_diff(
                            $calendar[$carId][$dateFormatted],
                            $bookedHours[$carId][$dateFormatted]
                        )
                    );
                }

                /**
                 * Remove hours in which user booked other cars
                 */
                if (isset($bookedHours['*'][$dateFormatted])) {
                    $calendar[$carId][$dateFormatted] = array_values(
                        array_diff(
                            $calendar[$carId][$dateFormatted],
                            $bookedHours['*'][$dateFormatted]
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
     * @param int $userId
     * @param array|int $carIds
     * @param Carbon $start
     * @param Carbon $end
     * @return array
     */
    public function bookingCalendar(int $userId, $carIds, Carbon $start, Carbon $end) : array
    {
        $carIds = (array)$carIds;

        $bookings = Booking::query()
            ->where(function(Builder $query) use ($userId, $carIds) {
                $query->whereIn('car_id', $carIds)
                    ->orWhere('user_id', $userId);
            })
            ->where('status', '!=', Booking::STATUS_CANCELED)
            ->where(function(Builder $query) use ($start, $end) {

                $query->where(function (Builder $query) use ($start, $end) {
                    $query->orWhereBetween('booking_starting_at', [$start, $end]);
                    $query->orWhereBetween('booking_ending_at', [$start, $end]);
                });

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

                $recurlyBookings[$walkThroughDate->format('l')][$booking->car_id][] = (int)$walkThroughDate->hour;

                if ($booking->user_id == $userId) {
                    $recurlyBookings[$walkThroughDate->format('l')]['*'][] = (int)$walkThroughDate->hour;
                }

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

                $results[$booking->car_id][$ymd][] = (int)$walkThroughDate->hour;

                if ($booking->user_id == $userId) {
                    $results['*'][$ymd][] = (int)$walkThroughDate->hour;
                }

                $walkThroughDate->addHour();
            }
        }

        /**
         * Merge recurring bookings with one-time into resulting calendar
         */
        $walkThroughDate = clone $start;

        while ($walkThroughDate->lessThan($end)) {

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
        $sum = array_sum(array_map('count', $availability));

        if ($sum == 0) {
            return false;
        }

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

        $booked = $this->bookingCalendar(auth()->user()->id, $availability->pluck('car_id')->toArray(), $from, $to);
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