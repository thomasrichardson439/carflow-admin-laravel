<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AwsHelper;
use App\Mail\UserPolicyNotification;
use App\Mail\UserProfileReviewNotification;
use App\Models\Booking;
use App\Models\Car;
use App\Models\CarCategory;
use App\Models\DrivingLicense;
use App\Models\TLCLicense;
use App\Models\UserProfileUpdate;
use App\Repositories\BookingsRepository;
use App\Repositories\CarsRepository;
use Carbon\Carbon;
use DB;
use Mail;
use App\Models\User;
use Illuminate\Http\Request;
use Woo\GridView\DataProviders\EloquentDataProvider;
use App\Http\Controllers\Controller;
use App\Mail\UserRegistrationReviewNotification;

/**
 * Class UsersController
 * @package App\Http\Controllers\Admin
 */
class UsersController extends Controller
{
    /**
     * @var AwsHelper
     */
    private $awsHelper;
    private $carsRepository;
    private $bookingsRepository;

    public function __construct()
    {
        $this->awsHelper = new AwsHelper();
        $this->carsRepository = new CarsRepository();
        $this->bookingsRepository = new BookingsRepository();
    }

    /**
     * Display a listing of the users in admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataProvider = new EloquentDataProvider(
            User::query()->where('admin', 0)
                ->with('profileUpdateRequest')
                ->orderBy('id', 'ASC')
        );
        return view('admin.users.index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create', [
            'defaultApps' => [
                'Uber',
                'Lyft',
                'VIA',
                'Gett',
                'Juno',
                'Curb',
                'Arro',
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'full_name' => 'required|min:2|max:100',
            'address' => 'required|min:2|max:255',
            'phone' => 'required|string|max:255',
            'ridesharing_apps' => 'array',
            'ridesharing_apps.*' => 'string',
            'ridesharing_app_additional' => 'string|nullable',

            'driving_license_front' => 'required|image',
            'driving_license_back' => 'required|image',
            'tlc_license_front' => 'required|image',
            'tlc_license_back' => 'required|image',
        ], [
            'driving_license_front.required' => 'Driver license front is required',
            'driving_license_front.image' => 'Driver license front should be an image',
            'driving_license_back.required' => 'Driver license back is required',
            'driving_license_back.image' => 'Driver license back should be an image',
        ]);

        $user = new User;

        DB::transaction(function () use ($request, &$user) {
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->full_name = $request->full_name;
            $user->address = $request->address;
            $user->phone = $request->phone;
            $user->status = \ConstUserStatus::PENDING;
            $user->save();

            $apps = $request->ridesharing_apps ?? [];

            if (!empty($request->ridesharing_app_additional)) {
                $apps = array_merge(
                    $apps,
                    array_filter(array_map('trim', explode(',', $request->ridesharing_app_additional)))
                );
            }

            $user->ridesharing_apps = implode(', ', $apps);
            $user->ridesharing_approved = !empty($apps);

            $drivingLicense = new DrivingLicense;

            $drivingLicense->front = $this->awsHelper->uploadToS3(
                $request->file('driving_license_front'),
                'users/driving_license/front_' . $user->id
            );

            $drivingLicense->back = $this->awsHelper->uploadToS3(
                $request->file('driving_license_back'),
                'users/driving_license/back_' . $user->id
            );

            $tlcLicense = new TLCLicense;

            $tlcLicense->front = $this->awsHelper->uploadToS3(
                $request->file('tlc_license_front'),
                'users/tlc_license/front_' . $user->id
            );

            $tlcLicense->back = $this->awsHelper->uploadToS3(
                $request->file('tlc_license_back'),
                'users/tlc_license/back_' . $user->id
            );

            $user->drivingLicense()->save($drivingLicense);
            $user->tlcLicense()->save($tlcLicense);

            $user->documents_uploaded = 1;

            $user->save();
        });

        return redirect('/admin/users/' . $user->id)->with('success', 'User successfully created');
    }

    /**
     * Display the specified user in admin.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.show', [
            'user' => $user,
            'profileUpdateRequest' => $user->profileUpdateRequest,
            'recurringBookingsProvider' => new EloquentDataProvider(
                $user->bookings()
                    ->getQuery()
                    ->where('is_recurring', true)
                    ->where('status', '<>', 'canceled')
            ),
            'oneTimeBookingsProvider' => new EloquentDataProvider(
                $user->bookings()
                    ->getQuery()
                    ->where('is_recurring', false)
                    ->where('status', '<>', 'canceled')
            ),
            'averageBookingTime' => Booking::query()
                ->where('user_id', $user->id)
                ->average(\DB::raw('booking_ending_at - booking_starting_at')) / (60 * 60),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $this->validate($request, [
            'full_name' => 'required|string|max:255',
            'email' => 'required|unique:users,email,' . $user->id . '|email',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'ridesharing_apps' => 'array',
            'ridesharing_apps.*' => 'string',
            'ridesharing_app_additional' => 'string|nullable',
            'policy_number' => 'string|max:255',
        ]);

        $apps = $request->ridesharing_apps ?? [];

        if (!empty($request->ridesharing_app_additional)) {
            $apps = array_merge(
                $apps,
                array_filter(array_map('trim', explode(',', $request->ridesharing_app_additional)))
            );
        }

        $user->fill($request->all());
        $user->ridesharing_apps = implode(', ', $apps);
        $user->saveOrFail();

        return redirect()->back()->with('success', 'User successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::query()->findOrFail($id);
        $user->forceDelete();
        return redirect('/admin/users')->with('success', 'User successfully deleted');
    }

    /**
     * Reject profile changes
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rejectProfileChanges($id, Request $request)
    {
        $update = UserProfileUpdate::query()->findOrFail($id);

        $this->validate($request, [
            'reject_reason' => 'required',
        ]);

        $update->setAttribute('status', UserProfileUpdate::STATUS_REJECTED)->save();

        Mail::to($update->user->email)->send(
            new UserProfileReviewNotification($update->user, $update->status, $request->reject_reason)
        );

        return redirect()->back()->with('success', 'Changes were rejected');
    }

    /**
     * Approves profile changes
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approveProfileChanges($id)
    {
        $update = UserProfileUpdate::query()->findOrFail($id);

        $update->setAttribute('status', UserProfileUpdate::STATUS_APPROVED)->save();

        if (!empty($update->full_name)) {
            $update->user->full_name = $update->full_name;
        }

        if (!empty($update->email)) {
            $update->user->email = $update->email;
        }

        if (!empty($update->phone)) {
            $update->user->phone = $update->phone;
        }

        if (!empty($update->address)) {
            $update->user->address = $update->address;
        }

        $update->user->save();

        Mail::to($update->user->email)->send(
            new UserProfileReviewNotification($update->user, $update->status)
        );

        return redirect()->back()->with('success', 'Changes were approved');
    }

    /**
     * Reject user registration
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reject($id, Request $request)
    {
        $user = User::findOrFail($id);

        $this->validate($request, [
            'reject_reason' => 'required',
        ]);

        $user->status = \ConstUserStatus::REJECTED;
        $user->documents_uploaded = 0;
        $user->save();

        Mail::to($user->email)->send(
            new UserRegistrationReviewNotification($user, $user->status, $request->reject_reason)
        );

        return redirect()->back()->with('success', 'User successfully rejected');
    }

    /**
     * Approve user registration
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        $user = User::findOrFail($id);

        $user->status = \ConstUserStatus::APPROVED;
        $user->documents_uploaded = 1;
        $user->save();

        Mail::to($user->email)->send(
            new UserRegistrationReviewNotification($user, $user->status, 'Dummy reason')
        );

        return redirect()->back()->with('success', 'User successfully approved');
    }

    /**
     * Sends policy email
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function policy($id)
    {
        $user = User::findOrFail($id);

        if (empty($user->policy_number)) {
            return redirect()->back()->with('error', 'Policy number is not filled in user profile');
        }

        Mail::to(config('params.userPolicyManagerEmail'))->cc(config('params.userPolicyCcEmail'))->send(
            new UserPolicyNotification($user->policy_number, $user)
        );

        return redirect()->back()->with('success', 'Policy number added. Notification sent.');
    }

    public function booking_create($id)
    {
        $data['user'] = User::findOrFail($id);
        $data['vehicles'] = CarCategory::all();
        return view('admin.users.booking_filters', $data);
    }
    public function availableForBooking(Request $request, $id)
    {
        if(count($request->all()) == 0){
            return redirect('admin/users/'.$id.'/booking/create');
        }else{
            $this->validate($request, [
                'available_from' => 'date|date_format:"l, j M Y h:i A"|required|after:yesterday',
                'available_to' =>   'date|date_format:"l, j M Y h:i A"|required|after:available_from',
                'categories' => 'array',
                'categories.*' => 'integer|exists:car_categories,id',
                'pickup_location_lat' => 'numeric',
                'pickup_location_lon' => 'numeric|required_with:pickup_location_lat',
                'allowed_range_miles' => 'integer|required_with:pickup_location_lat|min:1|max:100',
                'allowed_recurring' => 'boolean',
            ]);
            $req = $request->all();

            switch ($req['allowed_range_miles']){
                case 1:
                    $req['allowed_range_miles'] = 0.5;
                    break;
                case 2:
                    $req['allowed_range_miles'] = 1;
                    break;
                case 3:
                    $req['allowed_range_miles'] = 2;
                    break;
                case 4:
                    $req['allowed_range_miles'] = 5;
                    break;
                case 5:
                    $req['allowed_range_miles'] = 10;
                    break;
                case 6:
                    $req['allowed_range_miles'] = 10000;
                    break;
            }
            $data['cars']= $this->carsRepository->availableForBooking($req);
            $data['user']= User::findOrFail($id);
//            dd($data);

            return view('admin.users.booking_available_cars', $data);
        }
    }

    public function bookViewCar($id, $car_id){
        $model = Car::query()->findOrFail($car_id);

        $from = mktime(date("H", time()), (date("i", time()) + 1), 0, date("m", time()), date("d", time()), date("Y", time()));
        $available_from = date("Y-m-d h:i A", $from);
        $to = mktime(0, 0, 0, date("m", time())+2, 1, date("Y", time()));
        $available_to = date("Y-m-d h:i A", $to);

        $dateFrom = Carbon::parse($available_from);
        $dateTo = Carbon::parse($available_to);

        $data['user']= User::findOrFail($id);
        $data['car']= $this->carsRepository->show($model);
        $calendar = $this->carsRepository->availabilityCalendar(
            $model->availabilitySlots()->get(), $dateFrom, $dateTo,
            $this->carsRepository->bookingCalendar($id, $model->id, $dateFrom, $dateTo)
        )[$model->id];
        $data['calendar'] = json_encode($calendar);
//        dd($data);
        return view('admin.users.booking_view_car', $data);
    }

    public function bookPreview($id, $car_id, Request $request)
    {
        /**
         * @var $model Car
         */
        $model = Car::query()->findOrFail($car_id);

        $this->validate($request, [
            'calendar_date_from' => 'date|date_format:"Y-m-d h:i A"|required|after:now',
            'calendar_date_to' => 'date|date_format:"Y-m-d h:i A"|required|after:calendar_date_from',
        ]);

        $dateFrom = Carbon::parse($request->calendar_date_from);
        $dateTo = Carbon::parse($request->calendar_date_to);

        $data['user']= User::findOrFail($id);
        $data['car']= $this->carsRepository->show($model);
        $data['calendar']= $this->carsRepository->availabilityCalendar(
            $model->availabilitySlots()->get(), $dateFrom, $dateTo,
            $this->carsRepository->bookingCalendar($id, $model->id, $dateFrom, $dateTo)
        )[$model->id];
//        dd($data);
        return view('admin.users.booking_view_car', $data);
    }

    public function bookComplete($id, $car_id, Request $request){
        $data['user']= User::findOrFail($id);
        $model = Car::query()->findOrFail($car_id);

        $this->validate($request, [
            'calendar_date_from' => 'required|date|date_format:"Y-m-d h:i A"|after:now',
            'calendar_date_to' => 'required|date|date_format:"Y-m-d h:i A"|after:calendar_date_from',
            'is_recurring' => 'required|boolean',
        ]);

        $startingAt = Carbon::parse($request->calendar_date_from);
        $endingAt = Carbon::parse($request->calendar_date_to);

        /**
         * This conditions means that app should accept ending date without including next hour
         */
        if ($endingAt->minute != 59) {
//            return $this->validationErrors([
//                'calendar_date_to' => 'Minute should be 59',
//            ]);
            return redirect('admin/users/'.$id.'/booking/view/'.$car_id)->withErrors(['calendar_date_to' => 'Minute should be 59']);
        }

        if ($startingAt->diffInHours($endingAt) > config('params.maxBookingInHours')) {
//            return $this->validationErrors([
//                'calendar_date_to' => 'Interval could not be more than ' . config('params.maxBookingInHours') . ' hours',
//            ]);
            return redirect('admin/users/'.$id.'/booking/view/'.$car_id)->withErrors([
                'calendar_date_to' => 'Interval could not be more than ' . config('params.maxBookingInHours') . ' hours',
            ]);
        }

        if (!$this->carsRepository->carIsAvailable($model->id, $startingAt, $endingAt)) {
            return redirect('admin/users/'.$id.'/booking/view/'.$car_id)->withErrors([
                'calendar_date_from' => 'Some of this hours are disabled for booking',
            ]);
//            return $this->validationErrors([
//                'calendar_date_from' => 'Some of this hours are disabled for booking',
//            ]);
        }

        if (!$this->bookingsRepository->checkIntervalIsNotBooked(
            auth()->user()->id, $model->id, $startingAt, $endingAt
        )) {
            return redirect('admin/users/'.$id.'/booking/view/'.$car_id)->withErrors([
                'calendar_date_from' => 'Picked range contains already booked hours',
            ]);
//            return $this->validationErrors([
//                'calendar_date_from' => 'Picked range contains already booked hours',
//            ]);
        }

        $booking = $this->bookingsRepository->create([
            'user_id' => $id,
            'car_id' => $car_id,
            'booking_starting_at' => $startingAt->timestamp,
            'booking_ending_at' => $endingAt->timestamp,
            'is_recurring' => $request->is_recurring,
            'starting_at_weekday' => $request->is_recurring ? strtolower($startingAt->format('l')) : null,
            'ending_at_weekday' => $request->is_recurring ? strtolower($endingAt->format('l')) : null,
        ]);
        $data['booking'] = $booking;
        return view('admin.users.booking_complete', $data);
    }

    public function bookEdit($id, $booking_id){
        $booking = $this->findModel($booking_id);
        $data['booking'] = $this->bookingsRepository->show($booking);
        $data['user']= User::findOrFail($id);

//        $car_id = $data['booking']['car']['id'];
//        $model = Car::query()->findOrFail($car_id);
//        $from = mktime(date("H", time()), (date("i", time()) + 1), 0, date("m", time()), date("d", time()), date("Y", time()));
//        $available_from = date("Y-m-d h:i A", $from);
//        $to = mktime(0, 0, 0, date("m", time())+2, 1, date("Y", time()));
//        $available_to = date("Y-m-d h:i A", $to);
//        $dateFrom = Carbon::parse($available_from);
//        $dateTo = Carbon::parse($available_to);
//
//        $calendar = $this->carsRepository->availabilityCalendar(
//            $model->availabilitySlots()->get(), $dateFrom, $dateTo,
//            $this->carsRepository->bookingCalendar($id, $model->id, $dateFrom, $dateTo)
//        )[$model->id];
//        $data['calendar'] = json_encode($calendar);
//        $req = array(
//            "available_from" => $available_from,
//            "available_to" => $available_to,
//        );
//        $data['cars']= $this->carsRepository->availableForBooking($req);
//        dd($data);
        return view('admin.users.booking_edit', $data);
    }
    public function bookDelete($id, $booking_id){
        $booking = $this->findModel($booking_id);
        if (!in_array($booking->status, [Booking::STATUS_PENDING, Booking::STATUS_DRIVING])) {
            abort(409, 'Unable to cancel ride');
        }
        $result = $this->bookingsRepository->cancelRide($booking);
        return redirect(url('admin/users/'.$id.'?booking=1'));

    }
    private function findModel($id) : Booking
    {
        /**
         * @var $booking Booking
         */
        $booking = Booking::query()->findOrFail($id);

        return $booking;
    }
    private function validationErrors(array $errors)
    {
        return response()->json([
            'status' => 'failed',
            'data' => [],
            'error' => [
                'type' => 'validation',
                'message' => 'The given data was invalid.',
                'errors' => $errors,
            ]
        ], 422);
    }
}
