<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DrivingLicense;
use App\Models\TLCLicense;
use App\Models\User;
use Aws\S3\S3Client;
use DB;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Storage;

/**
 * Class AuthController
 * @package App\Http\Controllers\Api
 */
class AuthController extends BaseApiController
{

    /**
     * AuthController constructor.
     */
    public function __construct()
    {
        $this->middleware('api')->except('validateEmail');
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

        return $this->success([
            'email' => $exists ? 'taken' : 'free'
        ], $exists ? 406 : 200);
    }

    /**
     * Store user in database
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registers(Request $request)
    {
        $this->validate($request, $this->rules());

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

            /**
             * @var $client S3Client
             */
            $client = \App::make('aws')->createClient('s3');

            $licenseFront = $request->file('driving_license_front');
            $drivingLicense->front = $client->putObject([
                'Bucket'     => getenv('AWS_BUCKET'),
                'Key'        => 'users/driving_license_front_' . getenv('APP_ENV') . $user->id . '.' . $licenseFront->extension(),
                'SourceFile' => $licenseFront->getPathName(),
            ])['ObjectURL'];

            $licenseBack = $request->file('driving_license_back');
            $drivingLicense->back = $client->putObject([
                'Bucket'     => getenv('AWS_BUCKET'),
                'Key'        => 'users/driving_license_back_' . getenv('APP_ENV') . $user->id . '.' . $licenseBack->extension(),
                'SourceFile' => $licenseBack->getPathName(),
            ])['ObjectURL'];

            $tlcLicense = new TLCLicense;

            $licenseFront = $request->file('tlc_license_front');
            $tlcLicense->front = $client->putObject([
                'Bucket'     => getenv('AWS_BUCKET'),
                'Key'        => 'users/tlc_license_front_' . getenv('APP_ENV') . $user->id . '.' . $licenseFront->extension(),
                'SourceFile' => $licenseFront->getPathName(),
            ])['ObjectURL'];

            $licenseBack = $request->file('tlc_license_back');
            $tlcLicense->back = $client->putObject([
                'Bucket'     => getenv('AWS_BUCKET'),
                'Key'        => 'users/tlc_license_back_' . getenv('APP_ENV') . $user->id . '.' . $licenseBack->extension(),
                'SourceFile' => $licenseBack->getPathName(),
            ])['ObjectURL'];

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
     * Get rules for register step
     *
     * @return array
     */
    protected function rules()
    {
        return [
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
        ];
    }
}
