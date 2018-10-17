<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Models\BookingEndedReport;
use App\Models\BookingIssueReport;
use App\Models\BookingReceipt;
use App\Models\Car;
use App\Models\LateNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Expression;
use Illuminate\Http\UploadedFile;

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
     * @param Carbon $start
     * @param Carbon $end
     * @return bool
     */
    public function checkIntervalIsNotBooked(int $carId, Carbon $start, Carbon $end) : bool
    {
        return !($this->model->query()
            ->where(['car_id' => $carId])
            ->where(function(Builder $query) use ($start, $end) {
                $query->where('booking_starting_at', '<=', $start);
                $query->where('booking_ending_at', '>=', $start);

                $query->orWhere('booking_starting_at', '<=', $end);
                $query->where('booking_ending_at', '>=', $end);
            })
            ->exists());
    }

    /**
     * Allows to get a list of slots which are already booked
     * @param Car $car
     * @return array
     */
    public function bookedSlots(Car $car) : array
    {
        $bookings = $this->model->query()->where(['car_id' => $car->id])->get();

        if ($bookings->isEmpty()) {
            return [];
        }

        /**
         * Each hour from hours list means that this hour is booked from h:00 to h:59
         */
        $slots = [];

        $carBookingHoursAmount = $car->booking_available_from_carbon->diffInHours(
            $car->booking_available_to_carbon
        );

        foreach ($bookings as $booking) {

            /**
             * @var Carbon $walkThroughDate
             */
            $walkThroughDate = clone $booking->booking_starting_at;

            while ($walkThroughDate->lessThan($booking->booking_ending_at)) {

                $slots[$walkThroughDate->format('Y-m-d')][] = $walkThroughDate->format('H:i');

                $walkThroughDate->addHour();
            }
        }

        foreach ($slots as $date => &$hours) {

            sort($hours);

            if (count($hours) == $carBookingHoursAmount + 1) {
                $hours = false;
            }
        }

        return $slots;
    }

    /**
     * Allows to fetch a list of cars which booking by user is upcoming
     * @param int $userId
     * @return array
     */
    public function upcoming(int $userId) : array
    {
        $rows = $this->model->query()
            ->where('booking_starting_at', '>', now())
            ->where('user_id', $userId)
            ->where('status', 'pending')
            ->orderBy('booking_starting_at', 'ASC')
            ->get();

        $result = [];
        
        $now = now();

        foreach ($rows as $booking) {
            /** @var $booking Booking */

            $result[] = $this->show($booking);
        }

        return $result;
    }

    /**
     * Allows to get user's booking history
     * @param int $userId
     * @return Collection
     */
    public function history(int $userId) : array
    {
        $rows = $this->model->query()
            ->where('status', 'ended')
            ->where('user_id', $userId)
            ->orderBy('booking_ending_at', 'DESC')
            ->get();

        $result = [];

        foreach ($rows as $booking) {
            /** @var $booking Booking */

            $result[] = $this->show($booking);
        }

        return $result;
    }

    /**
     * @param Booking $booking
     * @param UploadedFile $plateImage
     * @return bool
     */
    public function validatePlateNumberCorrect(Booking $booking, UploadedFile $plateImage)
    {
        return true; //@todo: implement image OCR handler
    }

    /**
     * Allows to start ride
     * @param Booking $booking
     * @return array
     */
    public function startRide(Booking $booking) : array
    {
        $booking->status = Booking::STATUS_DRIVING;
        $booking->save();

        return $this->show($booking);
    }

    /**
     * Ends ride
     * @param Booking $booking
     * @param array $data
     * @return array
     * @throws \Throwable
     */
    public function endRide(Booking $booking, array $data) : array
    {
        \DB::transaction(function() use ($booking, $data) {
            $booking->status = Booking::STATUS_ENDED;
            $booking->save();

            $report = new BookingEndedReport();
            $report->fill($data);
            $report->booking_id = $booking->id;
            $report->save();
        });

        return $this->show($booking);
    }

    /**
     * Allows to cancel ride
     * @param Booking $booking
     * @return array
     */
    public function cancelRide(Booking $booking) : array
    {
        $booking->status = Booking::STATUS_CANCELED;
        $booking->save();

        return $this->show($booking);
    }

    /**
     * Allows to send issue report while/before/after driving
     * @param string $type
     * @param Booking $booking
     * @param array $data
     * @return array - booking
     */
    public function sendIssueReport(string $type, Booking $booking, array $data) : array
    {
        $model = new BookingIssueReport();
        $model->booking_id = $booking->id;
        $model->report_type = $type;
        $model->fill($data);
        $model->save();

        $booking->refresh();

        return $this->show($booking);
    }

    /**
     * @param Booking $booking
     * @param array $data
     * @return array - booking
     */
    public function sendLateNotification(Booking $booking, array $data) : array
    {
        $model = new LateNotification();
        $model->booking_id = $booking->id;
        $model->fill($data);
        $model->save();

        $booking->refresh();

        return $this->show($booking);
    }

    /**
     * @param Booking $booking
     * @param array $data
     * @return array
     */
    public function sendReceipt(Booking $booking, array $data) : array
    {
        $model = new BookingReceipt();
        $model->booking_id = $booking->id;
        $model->fill($data);
        $model->save();

        $booking->refresh();

        return $this->show($booking);
    }
}