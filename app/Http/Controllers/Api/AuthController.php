<?php

namespace App\Http\Controllers\Api;

use Storage;
use Validator;
use App\Models\User;
use App\Models\TLCLicense;
use App\Models\DrivingLicense;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

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

            return response()->json(['auth_token' => $token]);
        }

        return response()->json([
            'message' => 'Invalid login or password'
        ], 401);
    }


    /**
    * Store user in database
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\JsonResponse
    */
    public function register(Request $request)
    {
        $this->validate($request, $this->rules(1));
        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $auth_token = $user->createToken('Car Flow')->accessToken;

        return response()->json([
            'user' => $user,
            'auth_token' => $auth_token
        ], 201);
    }

    /**
    * Storing used additional details
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\JsonResponse
    */
    public function profileInfo(Request $request)
    {
        $this->validate($request, $this->rules(2));

        if (!auth()->user()->documents_uploaded) {
            return response()->json([
              'errors' => ['documents' => ['Documents not uploaded']]
            ], 422);
        }

        auth()->user()->update($request->all());

        return response()->json(auth()->user());
    }

    /**
    * Store user driving details
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\JsonResponse
    */
    public function uploadDocuments(Request $request)
    {
        $this->validate($request, [
          'ridesharing_approved' => 'required|boolean',
          'driving_license_front' => 'required|image',
          'driving_license_back' => 'required|image',
          'tlc_license_front' => 'required|image',
          'tlc_license_back' => 'required|image',
          'ridesharing_apps' => 'string',
        ]);

        $user = auth()->user();
        $this->storeDocuments($request, $user);
        $user->ridesharing_apps = $request->ridesharing_apps;
        $user->ridesharing_approved = $request->ridesharing_approved;
        $user->save();

        return response()->json($user);
    }

    /**
    * Store user documents if user approved for uber
    *
    * @param  \Illuminate\Http\Request  $request
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
    }

    /**
     * Get rules for register step
     *
     * @return array
     */
    protected function rules($step)
    {
        switch ($step) {
            case 1:
                return [
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|confirmed|min:6'
                ];
            case 2:
                return [
                    'full_name' => 'required|min:2|max:100',
                    'street' => 'required|min:2|max:100',
                    'city' => 'required|min:2|max:100',
                    'zip_code' => 'required|min:5|max:10',
                    'state' => 'required|min:2|max:15',
                    'phone' => 'required|min:9|max:19'
                ];
            case 3:
                return [
                    'documents' => 'required_if:uber_approved,1|size:3',
                    'documents.*' => 'required_if:uber_approved,1|image|max:5000'
                ];
        }
    }
}
