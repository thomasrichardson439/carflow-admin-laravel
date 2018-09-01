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
    * Store user in database
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function registerStep1(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

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
            return response()->json(['errors' => $validator->errors()], 400);
        }

        Auth::user()->update([
            'name' => $request->name,
            'street' => $request->street,
            'city' => $request->city,
            'zip_code' => $request->zip_code,
            'phone' => $request->phone,
            'step' => 2,
        ]);

        return response()->json(['user' => Auth::user()], 200);
    }

    /**
    * Store user driving details
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function registerStep3(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uber_approved' => 'required|boolean',
            'documents' => 'required_if:uber_approved,1',
            'documents.*' => 'image|max:5000'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $this->storeDocuments($request);
        $user = Auth::user();
        $user->status = $request->uber_approved ? 'pending' : 'approved',
        $user->uber_approved = $request->uber_approved,
        $user->step = 3
        $user->save()

        return response()->json(['user' => $user], 204);
    }

    /**
    * Store user documents if user approved for uber
    *
    * @param  \Illuminate\Http\Request  $request
    * @return boolean
    */
    private function storeDocuments($request)
    {
        if (!$request->uber_approved) {
            return false;
        }

        foreach ($request->documents as $document) {
            $path = $document->storeAs(
                'documents/'.Auth::id(),
                $document->getCLientOriginalName()
            );
            Auth::user()->documents()->save(new Document(
                'path' => 'storage/'.$path
            ));
        }
        
        return true;
    }
}
