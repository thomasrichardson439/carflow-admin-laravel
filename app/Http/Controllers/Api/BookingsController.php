<?php

namespace App\Http\Controllers\Api;

use App\Helpers\AwsHelper;
use App\Models\Booking;
use App\Models\Car;
use App\Repositories\BookingsRepository;
use App\Repositories\CarsRepository;
use Illuminate\Http\Request;

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

    /**
     * @var AwsHelper 
     */
    private $awsHelper;

    public function __construct()
    {
        $this->carsRepository = new CarsRepository();
        $this->bookingsRepository = new BookingsRepository();
        $this->awsHelper = new AwsHelper();
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
        return $this->success([
            'bookings' => $this->bookingsRepository->upcoming(auth()->user()->id)
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $booking = $this->findModel($id);

        return $this->success(
            $this->bookingsRepository->show($booking)
        );
    }

    /**
     * Starts a ride
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function start($id, Request $request)
    {
        $booking = $this->findModel($id);

        if ($booking->status != Booking::STATUS_PENDING) {
            abort(403, 'This drive could not be started (possible, it is already started)');
        }

        $this->validate($request, [
            'license_plate_photo' => 'image|required',
        ]);

        if (!$this->bookingsRepository->validatePlateNumberCorrect(
            $booking, $request->file('license_plate_photo')
        )) {
            return $this->validationErrors([
               'license_plate_photo' => 'Photo does not contain correct license plate',
            ]);
        }

        return $this->success($this->bookingsRepository->startRide($booking));
    }

    /**
     * Ends ride
     * @param $id
     * @param Request $request
     * @return array
     * @throws \Throwable
     */
    public function end($id, Request $request)
    {
        $booking = $this->findModel($id);

        if ($booking->status != Booking::STATUS_DRIVING) {
            abort(409, 'Unable to end non-started ride');
        }

        $this->validate($request, [
            'car_front_photo' => 'image|required',
            'car_back_photo' => 'image|required',
            'car_right_photo' => 'image|required',
            'car_left_photo' => 'image|required',
            'gas_tank_photo' => 'image|required',
            'notes' => 'string|max:1000',
        ]);

        $data = $request->all();

        $data['photo_front_s3_link'] =  $this->awsHelper->uploadToS3(
            $request->file('car_front_photo'), $booking->id . '_car_front'
        );

        $data['photo_back_s3_link'] = $this->awsHelper->uploadToS3(
            $request->file('car_back_photo'), $booking->id . '_car_back'
        );

        $data['photo_right_s3_link'] =  $this->awsHelper->uploadToS3(
            $request->file('car_right_photo'), $booking->id . '_car_right'
        );

        $data['photo_left_s3_link'] = $this->awsHelper->uploadToS3(
            $request->file('car_left_photo'), $booking->id . '_car_left'
        );

        $data['photo_gas_tank_s3_link'] = $this->awsHelper->uploadToS3(
            $request->file('gas_tank_photo'), $booking->id . '_gas_tank'
        );

        return $this->bookingsRepository->endRide($booking, $data);
    }

    /**
     * Cancel ride
     * @param $id
     * @return array
     */
    public function cancel($id)
    {
        $booking = $this->findModel($id);

        if ($booking->status != Booking::STATUS_PENDING) {
            abort(409, 'Unable to end ride that is not awaiting for start');
        }

        return $this->bookingsRepository->cancelRide($booking);
    }

    /**
     * Allows to find booking model
     * @param int $id
     * @return Booking
     */
    private function findModel($id) : Booking
    {
        /**
         * @var $booking Booking
         */
        $booking = Booking::query()->findOrFail($id);

        if ($booking->user_id != auth()->user()->id) {
            abort(403, 'You don\'t have access to this page');
        }

        return $booking;
    }
}
