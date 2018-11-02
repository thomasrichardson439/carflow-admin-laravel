<?php

namespace App\Http\Controllers\Api;

use App\Models\Car;
use App\Repositories\BookingsRepository;
use App\Repositories\CarsRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class CarsController extends BaseApiController
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
    public function availableForBooking(Request $request)
    {
        $this->validate($request, [
            'available_from' => 'date|date_format:"Y-m-d H:i"|required',
            'available_to' => 'date|date_format:"Y-m-d H:i"|required',
            'categories' => 'array',
            'categories.*' => 'integer|exists:car_categories,id',
            'allowed_recurring' => 'boolean',
        ]);

        return $this->success(
            $this->carsRepository->availableForBooking($request->all())
        );
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

        return $this->success([
            'car' => $this->carsRepository->show($model),
            'booked' => $this->bookingsRepository->bookedSlots($model)
        ]);
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
            return $this->error(403, 'Your account is not approved');
        }

        /**
         * @var $model Car
         */
        $model = Car::query()->findOrFail($id);

        $this->validate($request, [
            'booking_starting_at' => 'required|date|date_format:"Y-m-d H:i"|after:now',
            'booking_ending_at' => 'required|date|date_format:"Y-m-d H:i"|after:booking_starting_at',
            'is_recurring' => 'required|boolean',
        ]);

        $startingAt = Carbon::parse($request->booking_starting_at);
        $endingAt = Carbon::parse($request->booking_ending_at);

//        if ($startingAt->hour < $model->booking_available_from_carbon->hour) {
//            return $this->validationErrors([
//                'booking_starting_at' => 'Selected time is not available (too early)',
//            ]);
//        }

        /**
         * This conditions means that app should accept ending date without including next hour
         */
        if ($endingAt->minute != 59) {
            return $this->validationErrors([
                'booking_ending_at' => 'Minute should be 59',
            ]);
        }

//        if ($endingAt->hour > $model->booking_available_to_carbon->hour) {
//            return $this->validationErrors([
//                'booking_ending_at' => 'Selected time is not available (too late)',
//            ]);
//        }

        if (!$this->bookingsRepository->checkIntervalIsNotBooked(
            $model->id, $startingAt, $endingAt
        )) {

            return $this->validationErrors([
                'booking_starting_at' => 'Picked range contains already booked hours',
            ]);
        }

        $booking = $this->bookingsRepository->create([
            'user_id' => auth()->user()->id,
            'car_id' => $id,
            'booking_starting_at' => $startingAt->timestamp,
            'booking_ending_at' => $endingAt->timestamp,
            'is_recurring' => $request->is_recurring,
        ]);

        return $this->success([
            'booking' => $booking
        ]);
    }

    /**
     * Cars categories list
     * @return \Illuminate\Http\JsonResponse
     */
    public function categories()
    {
        return $this->success([
            'categories' => $this->carsRepository->categories(),
        ]);
    }

    /**
     * Cars manufacturers list
     * @return \Illuminate\Http\JsonResponse
     */
    public function manufacturers()
    {
        return $this->success([
            'categories' => $this->carsRepository->manufacturers(),
        ]);
    }
}
