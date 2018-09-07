<?php

namespace App\Http\Controllers\Api;

use Storage;
use Validator;
use App\Models\User;
use App\Models\Document;
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
    public function registerStep1(Request $request)
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
    public function registerStep2(Request $request)
    {
        $this->validate($request, $this->rules(2));
        auth()->user()->update($request->merge(['step' => 2])->all());

        return response()->json(auth()->user());
    }

    /**
    * Store user driving details
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\JsonResponse
    */
    public function registerStep3(Request $request)
    {
        $this->validate($request, ['uber_approved' => 'required|boolean']);

        if ($request->uber_approved) {
            $this->validate($request, $this->rules(3));
            $this->storeDocuments($request);
        }

        $request->merge([
             'status' => $request->uber_approved ? 'pending' : 'approved',
             'step' => 3
        ]);
        auth()->user()->update($request->all());

        return response()->json(auth()->user());
    }

    /**
    * Store user documents if user approved for uber
    *
    * @param  \Illuminate\Http\Request  $request
    * @return void
    */
    private function storeDocuments($request)
    {
        foreach ($request->documents as $document) {
            $path = $document->storeAs(
                'user/documents/' . auth()->id(),
                $document->getCLientOriginalName()
            );
            auth()->user()->documents()->save(
                new Document(['path' => Storage::url($path)])
            );
        }
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
