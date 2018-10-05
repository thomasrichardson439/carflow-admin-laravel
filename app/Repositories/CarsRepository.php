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
            ->where('booking_starting_at', '>', Carbon::now())
            ->get();

        $now = Carbon::now();

        foreach ($cars as $car) {
            $data[] = [
                'id' => $car->id,
                'manufacturer' => $car->manufacturer,
                'model' => $car->model,
                'image_s3_url' => $car->image_s3_url,
                'pickup_location' => $car->pickup_location,
                'return_location' => $car->return_location,
                'plate' => $car->plate,
                'color' => $car->color,
                'booking_starting_at' => dateResponseFormat($car->booking_starting_at, 'M j, h:i A'),
                'availability' => 'in ' . trim(str_replace('after', '', $car->booking_starting_at->diffForHumans($now))),
            ];
        }

        return $data;
    }

    /**
     * Allows to preview car booking with time slots
     * @param Car $car
     * @return array
     */
    public function bookingPreview(Car $car) : array
    {
        $slots = [];

        $range = range(
            $car->booking_starting_at->timestamp,
            $car->booking_ending_at->timestamp,
            60 * 60
        );

        foreach ($range as $timestamp) {
            $slots[$timestamp] = date('h:i A', $timestamp);
        }

        return [
            'id' => $car->id,
            'manufacturer' => $car->manufacturer,
            'model' => $car->model,
            'image_s3_url' => $car->image_s3_url,
            'pickup_location' => $car->pickup_location,
            'return_location' => $car->return_location,
            'plate' => $car->plate,
            'color' => $car->color,
            'booking_starting_at' => dateResponseFormat($car->booking_starting_at, 'h:i A'),
            'booking_ending_at' => dateResponseFormat($car->booking_ending_at, 'h:i A'),
            'slots' => $slots,
        ];
    }

    public function show($car) : array
    {
        return [
            'id' => $car->id,
            'manufacturer' => $car->manufacturer,
            'model' => $car->model,
            'image_s3_url' => $car->image_s3_url,
            'pickup_location' => $car->pickup_location,
            'return_location' => $car->return_location,
            'plate' => $car->plate,
            'color' => $car->color,
            'booking_starting_at' => dateResponseFormat($car->booking_starting_at, 'M j, h:i A'),
        ];
    }
}