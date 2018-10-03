<?php

namespace App\Repositories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Collection;
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
     * @param int $timestampStart
     * @param int $timestampEnd
     * @return bool
     */
    public function checkIntervalIsNotBooked(int $carId, int $timestampStart, int $timestampEnd) : bool
    {
        $bookings = $this->model->query()->where(['car_id' => $carId])->get();

        if ($bookings->isEmpty()) {
            return true;
        }

        foreach ($bookings as $booking) {
            if ($booking->booking_starting_at->timestamp <= $timestampStart &&
                $booking->booking_ending_at->timestamp > $timestampStart ||
                $booking->booking_starting_at->timestamp <= $timestampEnd &&
                $booking->booking_ending_at->timestamp >= $timestampEnd
            ) {
                return false;
            }
        }

        return true;
    }

    /**
     * Allows to get a list of slots which are already booked
     * @param int $carId
     * @return array
     */
    public function bookedSlots(int $carId) : array
    {
        $bookings = $this->model->query()->where(['car_id' => $carId])->get();

        if ($bookings->isEmpty()) {
            return [];
        }

        $slots = [];
        foreach ($bookings as $booking) {
            $slots = array_merge(
                $slots,
                range(
                    $booking->booking_starting_at->timestamp,
                    $booking->booking_ending_at->timestamp,
                    60 * 60
                )
            );
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
            ->where('booking_starting_at', '<', now())
            ->where('user_id', $userId)
            ->groupBy('car_id')
            ->get();
    }
}