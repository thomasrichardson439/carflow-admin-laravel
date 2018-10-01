<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DrivingLicense;
use App\Models\TLCLicense;
use App\Models\User;
use Illuminate\Http\Request;
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
        $this->middleware('api')->except('validateUser');
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
     * Validate user credintals
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateUser(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users,email'
        ]);

        return response()->json([], 204);
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
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->full_name = $request->full_name;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->status = \ConstUserStatus::PENDING;
        $user->save();

        $this->storeDocuments($request, $user);
        $auth_token = $user->createToken('Car Flow')->accessToken;

        return response()->json([
            'user' => $user,
            'auth_token' => $auth_token
        ], 201);
    }

    /**
     * Store user documents if user approved for uber
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    private function storeDocuments($request, $user)
    {
        $storage_folder = 'user/documents/' . auth()->id();

        $drivingLicense = new DrivingLicense;
        $drivingLicense->front = Storage::url(
            $request->driving_license_front->store($storage_folder)
        );
        $drivingLicense->back = Storage::url(
            $request->driving_license_back->store($storage_folder)
        );

        $tlcLicense = new TLCLicense;
        $tlcLicense->front = Storage::url(
            $request->tlc_license_front->store($storage_folder)
        );
        $tlcLicense->back = Storage::url(
            $request->tlc_license_back->store($storage_folder)
        );
        $user->drivingLicense()->save($drivingLicense);
        $user->tlcLicense()->save($tlcLicense);
        $user->documents_uploaded = 1;
        $user->ridesharing_apps = $request->ridesharing_apps;
        $user->ridesharing_approved = $request->ridesharing_approved;
        $user->save();
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
            'driving_license_front' => 'string',
            'driving_license_back' => 'string',
            'tlc_license_front' => 'string',
            'tlc_license_back' => 'string',
            'ridesharing_apps' => 'string',
        ];
    }
}
