<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DrivingLicense;
use App\Models\TLCLicense;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Storage;

/**
 * Class AuthController
 * @package App\Http\Controllers\Api
 */
class AuthController extends Controller
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

        return response()->json([
            'message' => 'Invalid login or password'
        ], 401);
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

        return response()->json(['email' => $exists ? 'taken' : 'free'], $exists ? 406 : 200);
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

        $user = User::where(['email' => $request->email])->first();

        if ($user && $user->status != \ConstUserStatus::REJECTED) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'email' => [
                        'This email is already taken',
                    ],
                ],
            ], 422);

        } elseif (!$user) {
            $user = new User;
        }

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

            $drivingLicense->front = $request->get('driving_license_front');
            $drivingLicense->back = $request->get('driving_license_back');

            $tlcLicense = new TLCLicense;
            $tlcLicense->front = $request->get('tlc_license_front');
            $tlcLicense->back = $request->get('tlc_license_back');

            $user->drivingLicense()->save($drivingLicense);
            $user->tlcLicense()->save($tlcLicense);

            $user->documents_uploaded = 1;
            $user->ridesharing_apps = $request->ridesharing_apps;
            $user->ridesharing_approved = $request->ridesharing_approved;
            $user->save();

            $auth_token = $user->createToken('Car Flow')->accessToken;
        });

        return response()->json([
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
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'full_name' => 'required|min:2|max:100',
            'address' => 'required|min:2|max:255',
            'phone' => 'required|min:9|max:19',
            'ridesharing_approved' => 'required|boolean',
            'ridesharing_apps' => 'required|string',

            'driving_license_front' => 'required|string',
            'driving_license_back' => 'required|string',
            'tlc_license_front' => 'required|string',
            'tlc_license_back' => 'required|string',
        ];
    }
}
