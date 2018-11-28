<?php

namespace App\Http\Controllers;

use App\Helpers\AwsHelper;
use App\Models\DrivingLicense;
use App\Models\TLCLicense;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class UsersController extends Controller
{
    private $awsHelper;

    public function __construct()
    {
        $this->awsHelper = new AwsHelper();
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

        return redirect('/welcome' . $user->id)->with('success', 'User successfully created');
    }
}
