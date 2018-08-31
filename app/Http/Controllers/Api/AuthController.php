<?php

namespace App\Http\Controllers\Api;

use Auth;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

    /**
     * Login user
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if (Auth::attemp(['email' => $request->email,
                          'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('Car Flow')->accessToken;

            return response()->json(['auth_token' => $token], 200);
        }

        return response()->json([
            'message' => 'Invalid login or password'], 401);
    }


    /**
    * Store a new user in database.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function registerStep1(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|confirmable|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $request->merge(['step' => 1]);
        $user = User::create($request->all());
        $auth_token = $user->createToken('Car Flow')->accessToken;

        return response()->json([
            'user' => $user,
            'auth_token' => $auth_token
        ], 201);
    }

    /**
    * Registration step2 for storing user details
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function registerStep2(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'name' => 'required|min:2|max:100',
           'street' => 'required|min:2|max:100',
           'city' => 'required|min:2|max:100',
           'zip_code' => 'required|min:5|max:10',
           'phone' => 'required|min:9|max:19'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $request->merge(['step' => 2]);
        $user = Auth::user()->update($request->all());

        return response()->json([
           'user' => $user,
           'auth_token' => $auth_token
        ], 201);
    }

    /**
    * Registration step3 for storing user driving documents
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function registerStep3(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'work_for_uber' => 'required|boolean',
            'documents.*' => 'required_if:work_for_uber,1|image|max:5000'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $request->merge(['step' => 3]);
        $user = Auth::user()->update($request->all());
        // Savign documents and sending email

        return response()->json([
           'user' => $user,
           'auth_token' => $auth_token
        ], 204);
    }
}
