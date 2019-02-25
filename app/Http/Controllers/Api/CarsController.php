<?php

namespace App\Http\Controllers\Api;

use DB;
use App\Models\Car;
use App\Repositories\BookingsRepository;
use App\Repositories\CarsRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use \Illuminate\Database\QueryException;

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
            'available_from' => 'date|date_format:"Y-m-d H:i"|required|after:yesterday',
            'available_to' => 'date|date_format:"Y-m-d H:i"|required|after:available_from',
            'categories' => 'array',
            'categories.*' => 'integer|exists:car_categories,id',
            'pickup_location_lat' => 'numeric',
            'pickup_location_lon' => 'numeric|required_with:pickup_location_lat',
            'allowed_range_miles' => 'integer|required_with:pickup_location_lat|min:1|max:100',
            'allowed_recurring' => 'boolean',
        ]);

        return $this->success(
            $this->carsRepository->availableForBooking($request->all())
        );
    }

    /**
     * Displays car booking preview
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bookPreview($id, Request $request)
    {
        /**
         * @var $model Car
         */
        $model = Car::query()->findOrFail($id);

        $this->validate($request, [
            'calendar_date_from' => 'date|date_format:"Y-m-d H:i"|required|after:now',
            'calendar_date_to' => 'date|date_format:"Y-m-d H:i"|required|after:calendar_date_from',
        ]);

        $dateFrom = Carbon::parse($request->calendar_date_from);
        $dateTo = Carbon::parse($request->calendar_date_to);

        return $this->success([
            'car' => $this->carsRepository->show($model),
            'calendar' => $this->carsRepository->availabilityCalendar(
                $model->availabilitySlots()->get(), $dateFrom, $dateTo,
                $this->carsRepository->bookingCalendar(auth()->user()->id, $model->id, $dateFrom, $dateTo)
            )[$model->id],
        ]);
    }

    /**
     * Create new booking for a car
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function book($id, Request $request)
    {
        $user = auth()->user();

        if ($user->status != \ConstUserStatus::APPROVED) {
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

        /**
         * This conditions means that app should accept ending date without including next hour
         */
        if ($endingAt->minute != 59) {
            return $this->error(422, 'Minute should be 59', 'validation');
        }

        if ($startingAt->diffInHours($endingAt) > config('params.maxBookingInHours')) {
            return $this->error(422, 'Interval could not be more than ' . config('params.maxBookingInHours') . ' hours', 'validation');
        }

        if (!$this->carsRepository->carIsAvailable($model->id, $startingAt, $endingAt)) {
            return $this->error(422, 'Some of this hours are disabled for booking', 'validation');
        }

        if (!$this->bookingsRepository->checkIntervalIsNotBooked(
            $user->id, $model->id, $startingAt, $endingAt
        )) {
            return $this->error(422, 'Picked range contains already booked hours', 'validation');
        }

        try {
            DB::transaction(function () use ($request, $id, $user, $startingAt, $endingAt, &$booking) {
                $booking = $this->bookingsRepository->create([
                    'user_id' => $user->id,
                    'car_id' => $id,
                    'booking_starting_at' => $startingAt->timestamp,
                    'booking_ending_at' => $endingAt->timestamp,
                    'is_recurring' => $request->is_recurring,
                    'starting_at_weekday' => $request->is_recurring ? strtolower($startingAt->format('l')) : null,
                    'ending_at_weekday' => $request->is_recurring ? strtolower($endingAt->format('l')) : null,
                ]);
            });
        } catch(QueryException $e) {
            return $this->error(422, 'Picked range contains already booked hours', 'validation');
        }

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
