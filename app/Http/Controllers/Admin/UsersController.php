<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AwsHelper;
use App\Mail\UserPolicyNotification;
use App\Mail\UserProfileReviewNotification;
use App\Models\Booking;
use App\Models\CarCategory;
use App\Models\DrivingLicense;
use App\Models\TLCLicense;
use App\Models\UserProfileUpdate;
use App\Repositories\BookingsRepository;
use App\Repositories\CarsRepository;
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
            ),
            'oneTimeBookingsProvider' => new EloquentDataProvider(
                $user->bookings()
                    ->getQuery()
                    ->where('is_recurring', false)
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
        $user->delete();

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

        Mail::to(config('params.userPolicyManagerEmail'))->send(
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

    public function bookViewCar($id, $car_id, Request $request){
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
            $cars= $this->carsRepository->availableForBooking($req);
            if(count($cars) > 0){
                foreach ($cars as $car){
                    if($car_id == $car['car']['id']){
                        $data['car'] = $car['car'];
                    }
                }
            }else{
                return redirect('admin/users/'.$id.'/booking/create');
            }

            $data['user']= User::findOrFail($id);
//            dd($data);

            return view('admin.users.booking_view_car', $data);
        }
    }

    public function bookPreview($id, $car_id, Request $request)
    {
        /**
         * @var $model Car
         */
        $model = Car::query()->findOrFail($car_id);

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
}
