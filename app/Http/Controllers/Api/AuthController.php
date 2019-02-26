<?php

namespace App\Http\Controllers\Api;

use App\Helpers\AwsHelper;
use App\Http\Controllers\Controller;
use App\Models\DeviceToken;
use App\Models\DrivingLicense;
use App\Models\TLCLicense;
use App\Models\User;
use Aws\S3\S3Client;
use DB;
use Illuminate\Http\Request;

/**
 * Class AuthController
 * @package App\Http\Controllers\Api
 */
class AuthController extends BaseApiController
{
    /**
     * @var AwsHelper
     */
    private $awsHelper;

    /**
     * AuthController constructor.
     */
    public function __construct()
    {
        $this->middleware('api')->except('validateEmail');
        $this->awsHelper = new AwsHelper();
    }

    /**
     * Login user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        if (auth()->attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            $token = auth()->user()->createToken('Car Flow')->accessToken;

            return response()->json(['auth_token' => $token, 'user' => auth()->user()]);
        }

        return $this->error(401, 'Invalid email or password');
    }

    /**
     * Allows to check if email is already taken
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);

        $exists = User::where(['email' => $request->get('email')])->exists();

        if ($exists) {
            return $this->error(406, 'Email is taken');
        }

        return $this->success(['email' => 'free']);
    }

    /**
     * Store user in database
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function registers(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'full_name' => 'required|min:2|max:100',
            'address' => 'required|min:2|max:255',
            'phone' => 'required|min:9|max:19',
            'ridesharing_approved' => 'required|boolean',
            'ridesharing_apps' => 'required|string',

            'driving_license_front' => 'required|image',
            'driving_license_back' => 'required|image',
            'tlc_license_front' => 'required|image',
            'tlc_license_back' => 'required|image',
        ]);

        $user = new User;
        $auth_token = null;

        DB::transaction(function () use ($request, &$user, &$auth_token) {
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->full_name = $request->full_name;
            $user->address = $request->address;
            $user->phone = $request->phone;
            $user->status = \ConstUserStatus::PENDING;
            $user->save();

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
            $user->ridesharing_apps = $request->ridesharing_apps;
            $user->ridesharing_approved = $request->ridesharing_approved;

            $user->save();

            $auth_token = $user->createToken('Car Flow')->accessToken;
        });

        return $this->success([
            'user' => $user,
            'auth_token' => $auth_token
        ], 201);
    }

    /**
     * Store device token in database
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function storeDeviceToken(Request $request)
    {
        $user = auth()->user();

        $this->validate($request, [
            'device_token' => 'required',
        ]);

        $deviceToken = DeviceToken::where('user_id', $user->id)
            ->where('device_token', $request->device_token)
            ->first();

        if($deviceToken){
            $deviceToken->updated_at = now();
            $deviceToken->save();
        }else{
            $deviceToken = new DeviceToken;

            DB::transaction(function () use ($request, &$user, &$deviceToken) {
                $deviceToken->user_id = $user->id;
                $deviceToken->device_token = $request->device_token;
                $deviceToken->save();
            });
        }

        return $this->success([
            'updated' => true,
            'device_token' => $deviceToken,
        ]);
    }

    /**
     * Remove device token from database
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function deleteDeviceToken(Request $request)
    {
        $user = auth()->user();

        $this->validate($request, [
            'device_token' => 'required',
        ]);

        $deviceToken = DeviceToken::where('user_id', $user->id)
            ->where('device_token', $request->device_token)
            ->first();

        if(!$deviceToken){
            return $this->error(409, 'Unable to find device token.');
        }

        $deviceToken->delete();

        return $this->success([
            'message' => 'Device token was successfully removed.',
        ]);
    }
}
