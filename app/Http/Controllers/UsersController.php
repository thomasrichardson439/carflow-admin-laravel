<?php

namespace App\Http\Controllers;

use App\Helpers\AwsHelper;
use App\Models\Car;
use App\Models\DrivingLicense;
use App\Models\Owner;
use App\Models\TLCLicense;
use App\Models\User;
use App\Repositories\CarsRepository;
use Illuminate\Http\Request;
use DB;

class UsersController extends Controller
{
    private $awsHelper;
    private $carsRepository;

    public function __construct()
    {
        $this->awsHelper = new AwsHelper();
        $this->carsRepository = new CarsRepository();
    }
    public function validateEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);

        $exists = User::where(['email' => $request->get('email')])->exists();

        if ($exists) {
            echo json_encode(['status'=>"failed",'message' => 'Email is taken']);exit;
        }
        echo json_encode(['status'=>"ok",'email' => 'free']);exit;
    }

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

            $drivingLicense = new DrivingLicense();

            $drivingLicense->front = $this->awsHelper->uploadToS3(
                $request->file('driving_license_front'),
                'users/driving_license/front_' . $user->id
            );

            $drivingLicense->back = $this->awsHelper->uploadToS3(
                $request->file('driving_license_back'),
                'users/driving_license/back_' . $user->id
            );

            $tlcLicense = new TLCLicense();

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

        return redirect('/welcome')->with('success', 'User successfully created');
    }

    public function store_car(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'full_name' => 'required|min:2|max:100',
            'category_id' => 'required|integer|exists:car_categories,id',
            'manufacturer_id' => 'required|integer|exists:car_manufacturers,id',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1990|max:' . date('Y'),
            'seats' => 'required|integer|max:10',
//            'owner' => 'required|string|max:255',
//            'policy_number' => 'string|max:255|nullable',
            'car_photo' => 'required|image',
            'tlc_photo' => 'required|image',
            'fh_photo' => 'required|image',
            'color' => 'required|string|max:255',
            'plate' => 'required|string|max:255',
            'allowed_recurring' => 'required|boolean',

            'pickup_location_lat' => 'required|numeric',
            'pickup_location_lon' => 'required|numeric',
            'full_pickup_location' => 'required|string|max:255',
        ]);

        $owner = new Owner;

        DB::transaction(function () use ($request, &$owner) {
            $owner->email = $request->email;
            $owner->password = bcrypt($request->password);
            $owner->full_name = $request->full_name;
            $owner->status = \ConstUserStatus::PENDING;
            $owner->save();
            $owner->tlc_photo = $this->awsHelper->uploadToS3(
                $request->file('tlc_photo'),
                'owners/tlc_photo_' . $owner->id
            );
            $owner->fh_photo = $this->awsHelper->uploadToS3(
                $request->file('fh_photo'),
                'owners/fh_photo_' . $owner->id
            );

            $owner->save();
        });

        $car = new Car();
        $car->fill(array_merge(
            $request->all(),
            ['image_s3_url' => '']
        ));
        $car->pickup_borough_id = 0;
        $car->return_borough_id = 0;
        $car->owner = $request->full_name;
        $car->policy_number = "not sure";

        $car->saveOrFail();

        $car->image_s3_url = $this->awsHelper->uploadToS3(
            $request->file('car_photo'),
            'cars/' . $car->id
        );

        $car->save();
        return redirect('/welcome')->with('success', 'Car successfully created');
    }
}
