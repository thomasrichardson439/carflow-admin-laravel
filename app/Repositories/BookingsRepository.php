<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Expression;

class BookingsRepository extends BaseRepository
{
    /**
     * @var Booking
     */
    protected $model;

    public function __construct()
    {
        $this->model = new Booking();
    }

    /**
     * Allows to check if interval is outside booked slots
     * @param int $carId
     * @param Carbon $start
     * @param Carbon $end
     * @return bool
     */
    public function checkIntervalIsNotBooked(int $carId, Carbon $start, Carbon $end) : bool
    {
        return !($this->model->query()
            ->where(['car_id' => $carId])
            ->where(function(Builder $query) use ($start, $end) {
                $query->where('booking_starting_at', '<=', $start);
                $query->where('booking_ending_at', '>=', $start);

                $query->orWhere('booking_starting_at', '<=', $end);
                $query->where('booking_ending_at', '>=', $end);
            })
            ->exists());
    }

    /**
     * Allows to get a list of slots which are already booked
     * @param Car $car
     * @return array
     */
    public function bookedSlots(Car $car) : array
    {
        $bookings = $this->model->query()->where(['car_id' => $car->id])->get();

        if ($bookings->isEmpty()) {
            return [];
        }

        /**
         * Each hour from hours list means that this hour is booked from h:00 to h:59
         */
        $slots = [];

        $carBookingHoursAmount = $car->starting_at_carbon->diffInHours(
            $car->ending_at_carbon
        );

        foreach ($bookings as $booking) {

            /**
             * @var Carbon $walkThroughDate
             */
            $walkThroughDate = clone $booking->booking_starting_at;

            while ($walkThroughDate->lessThan($booking->booking_ending_at)) {

                $slots[$walkThroughDate->format('Y-m-d')][] = $walkThroughDate->format('H:i');

                $walkThroughDate->addHour();
            }
        }

        foreach ($slots as $date => &$hours) {

            sort($hours);

            if (count($hours) == $carBookingHoursAmount + 1) {
                $hours = false;
            }
        }

        return $slots;
    }

    /**
     * Allows to fetch a list of cars which booking by user is upcoming
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function upcoming(int $userId) : Collection
    {
        return $this->model->query()
            ->select('car_id', new Expression('MIN(booking_starting_at) as booking_starting_at'))
            ->where('booking_starting_at', '>', now())
            ->where('user_id', $userId)
            ->groupBy('car_id')
            ->get();
    }

    /**
     * Allows to get user's booking history
     * @param int $userId
     * @return Collection
     */
    public function history(int $userId) : Collection
    {
        return $this->model->query()
            ->select('car_id')
            ->where('booking_ending_at', '<', now())
            ->where('user_id', $userId)
            ->groupBy('car_id')
            ->get();
    }
}