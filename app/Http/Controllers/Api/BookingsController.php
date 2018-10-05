<?php

namespace App\Http\Controllers\Api;

use App\Models\Car;
use App\Repositories\BookingsRepository;
use App\Repositories\CarsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookingsController extends BaseApiController
{
    /**
     * @var CarsRepository
     */
    private $carsRepository;

    /**
     * @var BookingsRepository
     */
    private $bookingsRepository;

    public function __construct()
    {
        $this->carsRepository = new CarsRepository();
        $this->bookingsRepository = new BookingsRepository();
    }

    /**
     * Displays user booking history
     * @return \Illuminate\Http\JsonResponse
     */
    public function history()
    {
        $bookings = $this->bookingsRepository->history(auth()->user()->id);
        $result = [];

        foreach ($bookings as $booking) {
            $result[] = $this->carsRepository->show(
                Car::query()->find($booking['car_id'])->first()
            );
        }

        return $this->success($result);
    }

    /**
     * Displays upcoming bookings
     * @return \Illuminate\Http\JsonResponse
     */
    public function upcoming()
    {
        $bookings = $this->bookingsRepository->upcoming(auth()->user()->id);
        $result = [];

        $now = now();

        foreach ($bookings as $booking) {
            $car = $this->carsRepository->show(
                Car::query()->find($booking['car_id'])->first()
            );

            $result[] = $car + [
                'user_booking_starting_at' => [
                    'object' => $booking['booking_starting_at'],
                    'formatted' => 'in ' . trim(str_replace('after', '', $booking['booking_starting_at']->diffForHumans($now))),
                ]
            ];
        }

        return $this->success($result);
    }
}
