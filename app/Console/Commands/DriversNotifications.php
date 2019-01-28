<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;

class DriversNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'drivers:notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send drivers notifications';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $allNotifications = [];

        /**
         * Trigger: 24 hours before pick up
         */
        $bookings24hr = Booking::query()
            ->where('status', '=', Booking::STATUS_PENDING)
            ->whereBetween('booking_starting_at', [
                now()->minute(0)->second(0)->addHours(24),
                now()->minute(0)->second(0)->addHours(24)->addMinutes(5)
            ])
            ->get();

        $allNotifications['before'][24] = $bookings24hr;
        /**
         * Trigger: 4 hours before pick up
         */
        $bookings4hr = Booking::query()
            ->where('status', '=', Booking::STATUS_PENDING)
            ->whereBetween('booking_starting_at', [
                now()->minute(0)->second(0)->addHours(4),
                now()->minute(0)->second(0)->addHours(4)->addMinutes(5)
            ])
            ->get();

        $allNotifications['before'][4] = $bookings4hr;

        /**
         * Trigger: 1 hour before pick up
         */
        $bookings1hr = Booking::query()
            ->where('status', '=', Booking::STATUS_PENDING)
            ->whereBetween('booking_starting_at', [
                now()->minute(0)->second(0)->addHours(1),
                now()->minute(0)->second(0)->addHours(1)->addMinutes(5)
            ])
            ->get();

        $allNotifications['before'][1] = $bookings1hr;

        /**
         * Trigger: 30 minutes after a pickup is missed
         */
        $bookingsPickupMissed30mins = Booking::query()
            ->where('status', '=', Booking::STATUS_PENDING)
            ->whereBetween('booking_starting_at', [
                now()->minute(0)->second(0)->subMinutes(30),
                now()->minute(0)->second(0)->subMinutes(30)->addMinutes(5)
            ])
            ->get();

        $allNotifications['missed'][30] = $bookingsPickupMissed30mins;

        /**
         * Trigger: 1 hour after a pickup is missed and no response to the 30 minutes late notification
         */
        $bookingsPickupMissed60mins = Booking::query()
            ->where('status', '=', Booking::STATUS_PENDING)
            ->whereBetween('booking_starting_at', [
                now()->minute(0)->second(0)->subMinutes(60),
                now()->minute(0)->second(0)->subMinutes(60)->addMinutes(5)
            ])
            ->get();

        $allNotifications['missed'][60] = $bookingsPickupMissed60mins;

        /**
         * Trigger: 1 hour and 30 minutes after a missed pickup
         */
        $bookingsPickupMissed90mins = Booking::query()
            ->where('status', '=', Booking::STATUS_PENDING)
            ->whereBetween('booking_starting_at', [
                now()->minute(0)->second(0)->subMinutes(90),
                now()->minute(0)->second(0)->subMinutes(90)->addMinutes(5)
            ])
            ->get();

        $allNotifications['missed'][90] = $bookingsPickupMissed90mins;

        if($allNotifications){
            dd($allNotifications);
        }
    }

    public function notification($token, $title)
    {
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $token=$token;

        $notification = [
            'title' => $title,
            'sound' => true,
        ];

        $extraNotificationData = ["message" => $notification,"moredata" =>'dd'];

        $fcmNotification = [
            //'registration_ids' => $tokenList, //multple token array
            'to'        => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $headers = [
            'Authorization: key=Legacy server key',
            'Content-Type: application/json'
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);

        return true;
    }
}
