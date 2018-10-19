<?php

namespace App\Http\Controllers\Api;

use App\Helpers\AwsHelper;
use App\Models\Booking;
use App\Models\BookingIssueReport;
use App\Models\LateNotification;
use App\Repositories\BookingsRepository;
use App\Repositories\CarsRepository;
use Illuminate\Http\Request;

class BookingsHelpController extends BaseApiController
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
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function damage($id, Request $request)
    {
        $booking = $this->findModel($id);

        $this->validate($request, [
            'car_photos' => 'required|array|max:4',
            'car_photos.*' => 'image',
            'description' => 'string|required|max:1000',
        ]);

        $data = $request->all();

        if ($request->hasFile('car_photos')) {

            $counter = 1;

            foreach ($request->file('car_photos') as $photo) {
                $data['photo_' . $counter++ . '_s3_link'] = $this->awsHelper->uploadToS3(
                    $photo, $booking->id . '_damage'
                );
            }
        }

        return $this->success(
            $this->bookingsRepository->sendIssueReport(
                BookingIssueReport::TYPE_DAMAGE,
                $booking,
                $data
            )
        );
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function malfunction($id, Request $request)
    {
        $booking = $this->findModel($id);

        $this->validate($request, [
            'car_photos' => 'required|array|max:4',
            'car_photos.*' => 'image',
            'description' => 'string|required|max:1000',
            'license_plate' => 'string|required|max:255',
        ]);

        $data = $request->all();

        if ($request->hasFile('car_photos')) {

            $counter = 1;

            foreach ($request->file('car_photos') as $photo) {
                $data['photo_' . $counter++ . '_s3_link'] = $this->awsHelper->uploadToS3(
                    $photo, $booking->id . '_malfunction'
                );
            }
        }

        return $this->success(
            $this->bookingsRepository->sendIssueReport(
                BookingIssueReport::TYPE_MALFUNCTION,
                $booking,
                $data
            )
        );
    }

    /**
     * Allows to notify administrator about late for ride
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function late($id)
    {
        $booking = $this->findModel($id);

        return $this->success(
            $this->bookingsRepository->sendLateNotification($booking)
        );
    }

    /**
     * Allows to fill late notification with more details
     * @param $lateNotificationId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function lateDetailed($id, $lateNotificationId, Request $request)
    {
        /**
         * @var LateNotification $lateNotification
         */
        $lateNotification = LateNotification::query()->findOrFail($lateNotificationId);

        $this->validate($request, [
            'delay_minutes' => 'int|required',
            'photo' => 'image|required',
            'reason' => 'string|required',
        ]);

        $data = $request->all();

        $data['photo_s3_link'] = $this->awsHelper->uploadToS3(
            $request->file('photo'), $lateNotification->booking->id . '_late'
        );

        return $this->success(
            $this->bookingsRepository->detailedLateNotification(
                $lateNotification, $data
            )
        );
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