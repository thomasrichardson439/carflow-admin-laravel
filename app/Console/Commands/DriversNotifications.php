<?php

namespace App\Console\Commands;

use App\Models\DeviceToken;
use Illuminate\Support\Facades\Log;
use App\Models\Booking;
use App\Repositories\BookingsRepository;
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
     * @var BookingsRepository
     */
    private $bookingsRepository;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->bookingsRepository = new BookingsRepository();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $allNotifications = [];

        Log::debug('Cron job is started sending notifications');

        $nowStart24 = now()->second(0)->addHours(24);
        $nowEnd24 = now()->second(0)->addHours(24);

        $nowStart4 = now()->second(0)->addHours(4);
        $nowEnd4 = now()->second(59)->addHours(4);

        $nowStart1 = now()->second(0)->addHours(1);
        $nowEnd1 = now()->second(59)->addHours(1);

        $nowMissedStart05 = now()->second(0)->subMinutes(30);
        $nowMissedEnd05 = now()->second(59)->subMinutes(30);

        $nowMissedStart1 = now()->second(0)->subMinutes(60);
        $nowMissedEnd1 = now()->second(59)->subMinutes(60);

        $nowMissedStart15 = now()->second(0)->subMinutes(90);
        $nowMissedEnd15 = now()->second(59)->subMinutes(90);

        $nowLeftStart2 = now()->second(0)->addHours(2);
        $nowLeftEnd2 = now()->second(59)->addHours(2);

        $nowLeftStart1 = now()->second(0)->addHours(1);
        $nowLeftEnd1 = now()->second(59)->addHours(1);

        $nowShouldBeReturnedStart = now()->second(0);
        $nowShouldBeReturnedEnd = now()->second(59);

        /**
         * Trigger: 24 hours before pick up
         */

        $bookings24hr = Booking::query()
            ->where('status', '=', Booking::STATUS_PENDING)
            ->whereBetween('booking_starting_at', [
                $nowStart24,
                $nowEnd24
            ])
            ->get();

        $allNotifications[Notification::TYPE_BEFORE_24] = $bookings24hr;

        if ($bookings24hr) {
            Log::debug('24 hrs trigger - We found ' . count($bookings24hr) . ' notifications');
        } else {
            Log::debug('24 hrs trigger - We found 0 notifications');
        }

        /**
         * Trigger: 4 hours before pick up
         */
        $bookings4hr = Booking::query()
            ->where('status', '=', Booking::STATUS_PENDING)
            ->whereBetween('booking_starting_at', [
                $nowStart4,
                $nowEnd4
            ])
            ->get();

        $allNotifications[Notification::TYPE_BEFORE_4] = $bookings4hr;

        if ($bookings4hr) {
            Log::debug('4 hrs trigger - We found ' . count($bookings4hr) . ' notifications');
        } else {
            Log::debug('4 hrs trigger - We found 0 notifications');
        }

        /**
         * Trigger: 1 hour before pick up
         */
        $bookings1hr = Booking::query()
            ->where('status', '=', Booking::STATUS_PENDING)
            ->whereBetween('booking_starting_at', [
                $nowStart1,
                $nowEnd1
            ])
            ->get();

        $allNotifications[Notification::TYPE_BEFORE_1] = $bookings1hr;

        if ($bookings1hr) {
            Log::debug('1 hr trigger - We found ' . count($bookings1hr) . ' notifications');
        } else {
            Log::debug('1 hr trigger - We found 0 notifications');
        }

        /**
         * Trigger: 30 minutes after a pickup is missed
         */
        $bookingsPickupMissed30mins = Booking::query()
            ->where('status', '=', Booking::STATUS_PENDING)
            ->whereBetween('booking_starting_at', [
                $nowMissedStart05,
                $nowMissedEnd05
            ])
            ->get();

        $allNotifications[Notification::TYPE_MISSED_0_5] = $bookingsPickupMissed30mins;

        if ($bookingsPickupMissed30mins) {
            Log::debug('30 mins trigger - We found ' . count($bookingsPickupMissed30mins) . ' missed notifications');
        } else {
            Log::debug('30 mins trigger - We found 0 missed notifications');
        }

        /**
         * Trigger: 1 hour after a pickup is missed and no response to the 30 minutes late notification
         */
        $bookingsPickupMissed60mins = Booking::query()
            ->where('status', '=', Booking::STATUS_PENDING)
            ->whereBetween('booking_starting_at', [
                $nowMissedStart1,
                $nowMissedEnd1
            ])
            ->get();

        $allNotifications[Notification::TYPE_MISSED_1] = $bookingsPickupMissed60mins;

        if ($bookingsPickupMissed60mins) {
            Log::debug('60 mins trigger - We found ' . count($bookingsPickupMissed60mins) . ' missed notifications');
        } else {
            Log::debug('60 mins trigger - We found 0 missed notifications');
        }

        /**
         * Trigger: 1 hour and 30 minutes after a missed pickup
         */
        $bookingsPickupMissed90mins = Booking::query()
            ->where('status', '=', Booking::STATUS_PENDING)
            ->whereBetween('booking_starting_at', [
                $nowMissedStart15,
                $nowMissedEnd15
            ])
            ->get();

        $allNotifications[Notification::TYPE_MISSED_1_5] = $bookingsPickupMissed90mins;

        if ($bookingsPickupMissed90mins) {
            Log::debug('90 mins trigger - We found ' . count($bookingsPickupMissed90mins) . ' missed notifications');
        } else {
            Log::debug('90 mins trigger - We found 0 missed notifications');
        }

        /**
         * Trigger: 2 hours left until vehicle is returned
         */
        $bookingsLeft120mins = Booking::query()
            ->where('status', '=', Booking::STATUS_DRIVING)
            ->whereBetween('booking_ending_at', [
                $nowLeftStart2,
                $nowLeftEnd2
            ])
            ->get();

        $allNotifications[Notification::TYPE_LEFT_2] = $bookingsLeft120mins;

        if ($bookingsLeft120mins) {
            Log::debug('120 mins trigger - We found ' . count($bookingsLeft120mins) . ' left notifications');
        } else {
            Log::debug('120 mins trigger - We found 0 left notifications');
        }

        /**
         * Trigger: 1 hour left until vehicle is returned
         */
        $bookingsLeft60mins = Booking::query()
            ->where('status', '=', Booking::STATUS_DRIVING)
            ->whereBetween('booking_ending_at', [
                $nowLeftStart1,
                $nowLeftEnd1
            ])
            ->get();

        $allNotifications[Notification::TYPE_LEFT_1] = $bookingsLeft60mins;

        if ($bookingsLeft60mins) {
            Log::debug('60 mins trigger - We found ' . count($bookingsLeft60mins) . ' left notifications');
        } else {
            Log::debug('60 mins trigger - We found 0 left notifications');
        }

        /**
         * Trigger: When the vehicle is supposed to be returned
         */
        $bookingsShouldBeReturned = Booking::query()
            ->where('status', '=', Booking::STATUS_DRIVING)
            ->whereBetween('booking_ending_at', [
                $nowShouldBeReturnedStart,
                $nowShouldBeReturnedEnd
            ])
            ->get();

        $allNotifications[Notification::TYPE_SHOULD_BE_RETURNED] = $bookingsShouldBeReturned;

        if ($bookingsShouldBeReturned) {
            Log::debug('Should be trigger - We found ' . count($bookingsShouldBeReturned) . ' should be returned notifications');
        } else {
            Log::debug('Should be trigger - We found 0 should be returned notifications');
        }

        if ($allNotifications) {
            foreach ($allNotifications as $notificationType => $userNotifications) {
                $k_index = 0;
                $deviceTokens = [];
                $amount_of_tokens = 0;
                foreach ($userNotifications as $key => $notification) {
                    if ($notification->user->deviceTokens) {
                        foreach ($notification->user->deviceTokens as $deviceKey => $deviceToken) {
                            if ($amount_of_tokens % 2 == 0) {
                                $k_index++;
                            }
                            $amount_of_tokens++;

                            if (isset($deviceTokens[$k_index]) && $deviceTokens[$k_index]) {
                                $deviceTokens[$k_index] .= $deviceToken->device_token . ',';
                            } else {
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

                    case Notification::TYPE_LEFT_2:
                        $message = "You have two hours of driving left.";
                        break;

                    case Notification::TYPE_LEFT_1:
                        $message = "You have one hour left to return the vehicle.";
                        break;

                    case Notification::TYPE_SHOULD_BE_RETURNED:
                        $message = "Your vehicle should be returned. Don’t forget to do the inspection.";
                        break;
                }

                if (!empty($message) && $deviceTokens) {
                    foreach ($deviceTokens as $k => $tokens) {
                        $this->notification($tokens, $message, $notificationType, $bookingsPickupMissed90mins);
                    }
                }
            }
        }

        Log::debug('Cron job is finished sending notifications');
    }

    public function notification($tokens, $message, $notificationType, $bookingsPickupMissed90mins = array())
    {
        $tokens = trim($tokens, ',');
        $tokens = explode(',', $tokens);

        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $firebaseLegacyServerKey = env('FIREBASE_SERVER_KEY', 'AAAAuU8tFkw:APA91bHX_53IW2inAuVysTvyUpDAShgJMQSNHTUBN-2R4ipZXTc09uV35Svr8yUrek9QPnzelmJPHWKoJF7SVI71GlEnLnc0tnWY718L4sXOGDCCk925lkbxuHQzpqbv1Wn6dwygWzSv');

        $notificationData = [
            "title" => "CarFlo",
            "body" => $message,
            "sound" => "default"
        ];

        if ($notificationType == Notification::TYPE_MISSED_0_5 || $notificationType == Notification::TYPE_MISSED_1) {
            $notificationData = array_merge($notificationData, [
                'positiveText' => 'yes',
                'positiveScreen' => 'Profile',
                'negativeText' => 'no',
                'negativeScreen' => 'RideHelp'
            ]);
        }

        $fcmNotification = [
            'registration_ids' => $tokens, //multiple token array
            'data' => $notificationData,
            'notification' => $notificationData,
            'content_available' => true,
            'priority' => 'high'
        ];

        $fcmData = json_encode($fcmNotification);

        // Prepare new cURL resource
        $ch = curl_init($fcmUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fcmData);

        // Set HTTP Header for POST request
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: key=' . $firebaseLegacyServerKey,
                'Content-Type: application/json',
                'Content-Length: ' . strlen($fcmData))
        );

        // Submit the POST request
        $result = curl_exec($ch);

        // Close cURL session handle
        curl_close($ch);

        Log::debug('FCM Response: ' . json_encode($result));

        $response = json_decode($result);

        if (is_object($response) && $response->failure > 0) {
            $badTokens = [];
            foreach ($response->results as $responseKey => $responseItem){
                if(!empty($responseItem->error) && isset($tokens[$responseKey])){
                    $needToDeleteToken = $tokens[$responseKey];
                    $badTokens[] = $needToDeleteToken;
                    unset($tokens[$responseKey]);

                    $deviceToken = DeviceToken::firstOrFail()->where('device_token', $needToDeleteToken);

                    if($deviceToken){
                        $deviceToken->delete();
                    }
                }
            }

            $notification = new Notification;
            $notification->device_token_ids = implode(',', $badTokens);
            $notification->type = $notificationType;
            $notification->status = false;
            $notification->save();
        }

        $notification = new Notification;
        $notification->device_token_ids = implode(',', $tokens);
        $notification->type = $notificationType;
        $notification->status = true;
        $notification->save();

        /** Here we cancel all missed bookings */
        if ($notificationType == Notification::TYPE_MISSED_1_5 && count($bookingsPickupMissed90mins) > 0) {
            foreach ($bookingsPickupMissed90mins as $key=>$missedBookings){
                $this->bookingsRepository->cancelRide($missedBookings);
            }
        }

        Log::debug('Notification - ' . $message . ' we sent to these tokens:' . implode(',', $tokens));

        return true;
    }
}
