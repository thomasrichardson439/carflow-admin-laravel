<?php

namespace App\Http\Controllers\Api;

use App\Models\Car;
use App\Repositories\BookingsRepository;
use App\Repositories\CarsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CarsController extends Controller
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
     * Displays cars list which are available for booking now
     * @return \Illuminate\Http\JsonResponse
     */
    public function availableForBooking()
    {
        return response()->json($this->carsRepository->allAvailableForBooking());
    }

    /**
     * Displays car booking preview
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function bookGet($id)
    {
        /**
         * @var $model Car
         */
        $model = Car::query()->findOrFail($id);

        return response()->json(
            $this->carsRepository->bookingPreview($model) +
            ['booked_slots' => $this->bookingsRepository->bookedSlots($model->id)]
        );
    }

    /**
     * Create new booking for a car
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bookPost($id, Request $request)
    {
        if (auth()->user()->status != \ConstUserStatus::APPROVED) {
            return response()->json(['error' => 'Your account is not approved'], 403);
        }

        /**
         * @var $model Car
         */
        $model = Car::query()->findOrFail($id);

        $this->validate($request, [
            'slot_start_timestamp' => 'required|integer|between:' . $model->booking_starting_at->timestamp . ',' . $model->booking_ending_at->timestamp,
            'slot_end_timestamp' => 'required|integer|between:' . $model->booking_starting_at->timestamp . ',' . $model->booking_ending_at->timestamp,
        ]);

        $this->validate($request, [
            'slot_end_timestamp' => 'integer|min:' . $request->slot_start_timestamp,
        ]);

        if (!$this->bookingsRepository->checkIntervalIsNotBooked(
            $model->id, $request->slot_start_timestamp, $request->slot_end_timestamp
        )) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => [
                    'slot_start_timestamp' => 'Picked slots are already booked',
                ]
            ], 422);
        }

        $booking = $this->bookingsRepository->create([
            'user_id' => auth()->user()->id,
            'car_id' => $id,
            'booking_starting_at' => $request->slot_start_timestamp,
            'booking_ending_at' => $request->slot_end_timestamp,
        ]);

        return response()->json(['booking' => $booking]);
    }
}
