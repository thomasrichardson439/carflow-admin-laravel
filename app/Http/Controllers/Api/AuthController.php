<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Models\User;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

    /**
     * @OA\Post(
     *   tags={"auth"},
     *   path="/api/login",
     *   summary="Login user",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Email and password",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="email", format="email", type="string", required={"true"}),
     *                 @OA\Property(property="password", format="password", type="string", required={"true"}),
     *            ),
     *         )
     *     ),
     *   @OA\Response(
     *       response=200,
     *       description="successfully login",
     *       @OA\JsonContent(
     *           @OA\Property(
     *               property="auth_token",
     *               type="string"
     *           )
     *      )
     *   ),
     *   @OA\Response(
     *       response="401",
     *       description="Unauthorized",
     *       @OA\JsonContent(@OA\Property(property="message", example="Invalid login or password", type="string"))
     *   ),
     *   @OA\Response(
     *       response="500",
     *       description="Server error"
     *   )
     * )
     *
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
    * @OA\Post(
    *   tags={"auth"},
    *   path="/api/register/step-1",
    *   summary="Create user",
    *   security={
    *     {"api_key": {}}
    *   },
    *     @OA\RequestBody(
    *         required=true,
    *         description="Email and password",
    *         @OA\MediaType(
    *             mediaType="multipart/form-data",
    *             @OA\Schema(
    *                 @OA\Property(property="email", format="email", type="string", required={"true"}),
    *                 @OA\Property(property="password", format="password", type="string", required={"true"}),
    *                 @OA\Property(property="password_confirmation", format="password", type="string", required={"true"}),
    *            ),
    *         )
    *     ),
    *   @OA\Response(
    *       response=201,
    *       description="successfully created",
    *       @OA\JsonContent(
    *           @OA\Property(property="auth_token",type="string"),
    *           @OA\Property(property="user", ref="#/components/schemas/User"),
    *      )
    *   ),
    *   @OA\Response(
    *       response="401",
    *       description="Unauthorized",
    *       @OA\JsonContent(@OA\Property(property="message", example="Unauthorized.", type="string"))
    *   ),
    *   @OA\Response(
    *       response="422",
    *       description="Validation failed",
    *       @OA\JsonContent(
    *           @OA\Property(property="message", example="The given data was invalid.", type="string"),
    *           @OA\Property(
    *               property="errors",
    *               type="object",
    *               @OA\Property(
    *                   property="email",
    *                   type="array",
    *                   @OA\Items(type="string", example="Email field is required.")
    *               )
    *           ),
    *       )
    *   ),
    *   @OA\Response(
    *       response="500",
    *       description="Server error"
    *   )
    * )
    *
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
    * @OA\Post(
    *   tags={"auth"},
    *   path="/api/register/step-2",
    *   summary="Storing user additional details",
    *   security={
    *     {"api_key": {}}
    *   },
    *     @OA\RequestBody(
    *         required=true,
    *         description="Updated user object",
    *         @OA\MediaType(
    *             mediaType="multipart/form-data",
    *             @OA\Schema(
    *                 @OA\Property(property="full_name", format="string", type="string", required={"true"}),
    *                 @OA\Property(property="street", format="string", type="string", required={"true"}),
    *                 @OA\Property(property="city", format="string", type="string", required={"true"}),
    *                 @OA\Property(property="zip_code", format="string", type="string", required={"true"}),
    *                 @OA\Property(property="state", format="string", type="string", required={"true"}),
    *                 @OA\Property(property="phone", format="string", type="string", required={"true"}),
    *            ),
    *         )
    *     ),
    *
    *   @OA\Response(
    *       response=200,
    *       description="successfully created",
    *       @OA\JsonContent(ref="#/components/schemas/User"),
    *   ),
    *   @OA\Response(
    *       response="401",
    *       description="Unauthorized",
    *       @OA\JsonContent(@OA\Property(property="message", example="Unauthorized.", type="string"))
    *   ),
    *   @OA\Response(
    *       response="422",
    *       description="Validation failed",
    *       @OA\JsonContent(
    *           @OA\Property(property="message", example="The given data was invalid.", type="string"),
    *           @OA\Property(
    *               property="errors",
    *               type="object",
    *               @OA\Property(
    *                   property="city",
    *                   type="array",
    *                   @OA\Items(type="string", example="City must be at least 5 characters.")
    *               )
    *           ),
    *       )
    *   ),
    *   @OA\Response(
    *       response="500",
    *       description="Server error"
    *   )
    * )
    *
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
    * @OA\Post(
    *   tags={"auth"},
    *   path="/api/register/step-3",
    *   summary="Storing user driving information",
    *   security={
    *     {"api_key": {}}
    *   },
    *     @OA\RequestBody(
    *         required=true,
    *         description="Updated user object",
    *         @OA\MediaType(
    *             mediaType="multipart/form-data",
    *             @OA\Schema(
    *                @OA\Property(property="uber_approved", type="boolean", format="boolean", required={"true"}),
    *                @OA\Property(property="documents[front_license]", type="file", format="image"),
    *                @OA\Property(property="documents[back_licence]", type="file", format="image"),
    *                @OA\Property(property="documents[tlc_licence]", type="file", format="image"),
    *             )
    *         )
    *     ),
    *
    *   @OA\Response(
    *       response=200,
    *       description="successfully created",
    *       @OA\JsonContent(ref="#/components/schemas/User")
    *   ),
    *   @OA\Response(
    *       response="401",
    *       description="Unauthorized",
    *       @OA\JsonContent(@OA\Property(property="message", example="Unauthorized.", type="string"))
    *   ),
    *   @OA\Response(
    *       response="422",
    *       description="Validation failed",
    *       @OA\JsonContent(
    *           @OA\Property(property="message", example="The given data was invalid.", type="string"),
    *           @OA\Property(
    *               property="errors",
    *               type="object",
    *               @OA\Property(
    *                   property="uber_approved",
    *                   type="array",
    *                   @OA\Items(type="string", example="Uber approved field is required.")
    *               )
    *           ),
    *       )
    *   ),
    *   @OA\Response(
    *       response="500",
    *       description="Server error"
    *   )
    * )
    *
    * Store user driving details
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\JsonResponse
    */
    public function registerStep3(Request $request)
    {
        $this->validate($request, $this->rules(3));
        $this->storeDocuments($request);
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
        if (!$request->uber_approved) {
            return ;
        }

        foreach ($request->documents as $document) {
            $path = $document->storeAs(
                'documents/' . auth()->id(),
                $document->getCLientOriginalName()
            );
            auth()->user()->documents()->save(
                new Document(['path' => 'storage/'.$path])
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
                    'uber_approved' => 'required|boolean',
                    'documents' => 'required_if:uber_approved,1|size:3',
                    'documents.*' => 'image|max:5000'
                ];
        }
    }
}
