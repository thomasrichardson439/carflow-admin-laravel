<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Models\BookingStartedReport;
use App\Models\BookingEndedReport;
use App\Models\BookingIssueReport;
use App\Models\BookingReceipt;
use App\Models\Car;
use App\Models\LateNotification;
use Carbon\Carbon;
use function foo\func;
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
    public function checkIntervalIsNotBooked(int $userId, int $carId, Carbon $start, Carbon $end) : bool
    {
        $bookings = $this->model->query()
            ->where('status', '!=', Booking::STATUS_CANCELED)
            ->where(function(Builder $query) use ($userId, $carId) {
                $query->where('car_id', $carId)
                    ->orWhere('user_id', $userId);
            })
            ->where(function(Builder $query) use ($start, $end) {
                $query->where(function (Builder $query) use ($start, $end) {
                    $query->orWhereBetween('booking_starting_at', [$start, $end]);
                    $query->orWhereBetween('booking_ending_at', [$start, $end]);
                })
                ->where('cancelled_at', '2000-00-00 00:00:00') //please have a look into database/migrations/2019_02_25_133736_add_cancelled_at_field_bookings_table.php
//                    we had a bug when it was ignoring booking_starting_at and booking_ending_at and was displaying current bookings
//                ->orWhere(function (Builder $query) use ($start, $end) {
                ->where(function (Builder $query) use ($start, $end) {
                    $query->where([
                        'starting_at_weekday' => strtolower($start->format('l')),
                    ]);

                    $query->orWhere([
                        'starting_at_weekday' => strtolower($end->format('l')),
                    ]);

                    $query->orWhere([
                        'ending_at_weekday' => strtolower($start->format('l')),
                    ]);

                    $query->orWhere([
                        'ending_at_weekday' => strtolower($end->format('l')),
                    ]);
                });
            })
            ->get();

        $walkerDate = clone $start;
        $interval = [];

        for (; $walkerDate->lessThanOrEqualTo($end); $walkerDate->addHour()) {
            $interval[$walkerDate->dayOfWeek][$walkerDate->hour] = 1;
        }

        foreach ($bookings as $booking) {
            /**
             * @var Booking $booking
             */

            /**
             * If booking is not recurring, that means that interfering booking found
             */
            if (!$booking->is_recurring) {
                return false;
            }

            /**
             * Recurring booking needs additional check
             */
            $walkerDate = clone $booking->booking_starting_at;

            for (; $walkerDate->lessThanOrEqualTo($booking->booking_ending_at); $walkerDate->addHour()) {

                if (isset($interval[$walkerDate->dayOfWeek][$walkerDate->hour])) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Allows to fetch a list of cars which booking by user is upcoming
     * @param string $recurring - all, one-time, recurring
     * @param int $userId
     * @return array
     */
    public function upcoming(string $recurring, int $userId) : array
    {
        $query = $this->model->query()
            ->where('user_id', $userId)
            ->whereIn('status', [Booking::STATUS_PENDING, Booking::STATUS_DRIVING])
            ->orderBy('booking_starting_at', 'ASC');
        
        switch ($recurring) {
            case 'one-time':
                $query->where('is_recurring', false);
                break;
                
            case 'recurring':
                $query->where('is_recurring', true);
                break;
        }

        $result = [];

        foreach ($query->get() as $booking) {
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
            ->whereIn('status', [Booking::STATUS_ENDED, Booking::STATUS_CANCELED])
            ->where('user_id', $userId)
            ->orderBy('booking_ending_at', 'ASC')
            ->get();

        $result = [];

        foreach ($rows as $booking) {
            /** @var $booking Booking */

            $result[$booking->booking_starting_at->format('l, j M')][] = $this->show($booking);
        }

        return $result;
    }

    /**
     * Allows to start ride
     * @param Booking $booking
     * @param array $data
     * @return array
     */
    public function startRide(Booking $booking, array $data) : array
    {
        \DB::transaction(function() use ($booking, $data) {
            $booking->status = Booking::STATUS_DRIVING;
            $booking->save();

            $report = new BookingStartedReport();
            $report->fill($data);
            $report->booking_id = $booking->id;
            $report->save();
        });

        $booking->refresh();

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

            if($booking->is_recurring){
                //TODO check this part because there is no check for availability, actually we need to fix logic and don't allow to book car if car has recurring bookings on this time period
                $newBooking = new Booking();
                $newBooking->user_id = $booking->user_id;
                $newBooking->car_id = $booking->car_id;
                $newBooking->booking_starting_at = Carbon::parse($booking->booking_starting_at)->addDay();
                $newBooking->booking_ending_at = Carbon::parse($booking->booking_ending_at)->addDay();
                $newBooking->is_recurring = $booking->is_recurring;
                $newBooking->starting_at_weekday = $booking->starting_at_weekday;
                $newBooking->ending_at_weekday = $booking->ending_at_weekday;
                $newBooking->save();
            }

            $report = new BookingEndedReport();
            $report->fill($data);
            $report->booking_id = $booking->id;
            $report->save();
        });

        $booking->refresh();

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
        $booking->cancelled_at = now()->second(0);
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
     * @return array - booking
     */
    public function sendLateNotification(Booking $booking) : array
    {
        $model = new LateNotification();
        $model->booking_id = $booking->id;
        $model->save();

        return $model->toArray();
    }

    /**
     * @param LateNotification $model
     * @param array $data
     * @return array
     */
    public function detailedLateNotification(LateNotification $model, array $data) : array
    {
        $model->fill($data);
        $model->save();

        $model->booking->refresh();

        return $this->show($model->booking);
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

    public function show($model, $renderCallback = null): array
    {
        $data = parent::show($model, $renderCallback);

        $data['booking_starting_at'] = dateResponseFormat($model->booking_starting_at, 'd M, h:i a');
        $data['booking_ending_at'] = dateResponseFormat($model->booking_ending_at, 'd M, h:i a');

        return $data;
    }
}