<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Models\Car;
use App\Models\CarCategory;
use App\Models\CarManufacturer;
use Carbon\Carbon;

class CarsRepository extends BaseRepository
{
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


        $now = Carbon::now();
        $data = [];

        foreach ($query->get() as $car) {

            $bookingStartingAt = Carbon::parse($car->booking_available_from);

            if ($bookingStartingAt->greaterThanOrEqualTo($now)) {
                $availability = 'Available now';
            } else {
                $availability = 'in ' . $bookingStartingAt->diffForHumans($now, true);
            }

            $data[] = [
                'car' => $this->show($car),
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
}