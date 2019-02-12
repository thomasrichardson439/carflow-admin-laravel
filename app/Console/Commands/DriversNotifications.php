<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\Notification;
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

        $allNotifications[Notification::TYPE_BEFORE_24] = $bookings24hr;

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

        $allNotifications[Notification::TYPE_BEFORE_4] = $bookings4hr;

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

        $allNotifications[Notification::TYPE_BEFORE_1] = $bookings1hr;

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

        $allNotifications[Notification::TYPE_MISSED_0_5] = $bookingsPickupMissed30mins;

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

        $allNotifications[Notification::TYPE_MISSED_1] = $bookingsPickupMissed60mins;

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

        $allNotifications[Notification::TYPE_MISSED_1_5] = $bookingsPickupMissed90mins;

        if($allNotifications){
            foreach ($allNotifications as $notificationType=>$userNotifications){
                $k_index = 0;
                $deviceTokens = [];
                $amount_of_tokens = 0;
                foreach ($userNotifications as $key=>$notification){
                    if($notification->user->deviceTokens){
                        foreach ($notification->user->deviceTokens as $deviceKey=>$deviceToken){
                            if($amount_of_tokens % 2 == 0){
                                $k_index++;
                            }
                            $amount_of_tokens++;

                            if(isset($deviceTokens[$k_index]) && $deviceTokens[$k_index]){
                                $deviceTokens[$k_index] .= $deviceToken->device_token . ',';
                            }else{
                                $deviceTokens[$k_index] = $deviceToken->device_token . ',';
                            }
                        }


                    }
                }

                $message = '';

                switch ($notificationType) {
                    case Notification::TYPE_BEFORE_24:
                        $message = "You have 24 hours until your vehicle pickup. Don't forget to upload all of your documents to you ride-share app?";
                        break;
                    case Notification::TYPE_BEFORE_4:
                        $message = "You have 4 hours until your vehicle pickup. Don't forget to upload all of your documents to you ride-share app?";
                        break;
                    case Notification::TYPE_BEFORE_1:
                        $message = "You have 1 hour until your vehicle pickup. Get there early so you can inspect the vehicle.";
                        break;

                    case Notification::TYPE_MISSED_0_5:
                        $message = "You are 30 minutes late to pick up your vehicle. Are you still coming to pick up vehicle?";
                        break;

                    case Notification::TYPE_MISSED_1:
                        $message = "You are one hour late for your pickup. Are you still going to pick up the vehicle?";
                        break;

                    case Notification::TYPE_MISSED_1_5:
                        $message = "You missed a vehicle that you rented.";
                        break;
                }

                if(!empty($message) && $deviceTokens){
                    foreach ($deviceTokens as $k=>$tokens){
                        $this->notification($tokens, $message, $notificationType);
                    }
                }
            }
        }
    }

    public function notification($tokens, $message, $notificationType)
    {
        $tokens = trim($tokens, ',');
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $firebaseLegacyServerKey = env('FIREBASE_LEGACY_SERVER_KEY', 'AIzaSyD_uyZ6v4tHRS4M7n65WyfzByxsbPDiGj0');

        $notification = [
            'title' => $message,
            'sound' => true,
        ];

        $extraNotificationData = ["message" => $notification];

        $fcmNotification = [
            'registration_ids' => $tokens, //multple token array
//            'to'        => $token->device_token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $headers = [
            'Authorization: key=' . $firebaseLegacyServerKey,
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

        $response = json_decode($result);

        if(is_object($response) &&  $response->success){
            $status = true;
        }else{
            $status = false;
        }

        $notification = new Notification;
        $notification->device_token_ids = $tokens;
        $notification->type = $notificationType;
        $notification->status = $status;
        $notification->save();

        return true;
    }
}
