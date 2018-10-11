<?php

namespace App\Repositories;

use App\Models\Car;
use Carbon\Carbon;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * @return array
     */
    public function allAvailableForBooking() : array
    {
        $data = [];

        $cars = $this->model
            ->query()
            ->get();

        $now = Carbon::now();

        foreach ($cars as $car) {

            $bookingStartingAt = Carbon::parse($car->booking_starting_at);

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
}