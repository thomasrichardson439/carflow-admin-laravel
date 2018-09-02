<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{

    /**
     * @OA\Get(
     *   tags={"user"},
     *   path="/api/users",
     *   summary="All users",
     *   security={
     *     {"api_key": {}}
     *   },
     *   @OA\Response(
     *       response=200,
     *       description="successfully get all users",
     *       @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/User")
     *       )
     *   ),
     *   @OA\Response(
     *     response="401",
     *     description="Unauthorized",
     *     @OA\JsonContent(@OA\Property(property="message", example="Unauthorized.", type="string"))
     *   ),
     *   @OA\Response(
     *     response="500",
     *     description="Server error"
     *   )
     * )
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    /**
     * @OA\Get(
     *   tags={"user"},
     *   path="/api/users/{id}",
     *   summary="User details",
     *   security={
     *     {"api_key": {}}
     *   },
     *   @OA\Parameter(
     *     name="id",
     *     required=true,
     *     in="path",
     *     description="The user id",
     *     @OA\Schema(
     *         type="string"
     *     )
     *   ),
     *   @OA\Response(
     *       response=200,
     *       description="successfully find user",
     *       @OA\JsonContent(ref="#/components/schemas/User")
     *   ),
     *   @OA\Response(
     *     response="401",
     *     description="Unauthorized",
     *     @OA\JsonContent(@OA\Property(
     *        property="message",
     *        example="Unauthorized.",
     *        type="string")
     *    )
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="Not found",
     *     @OA\JsonContent(
     *         @OA\Property(property="message", example="User not found", type="string"))
     *   ),
     *   @OA\Response(
     *     response="500",
     *     description="Server error"
     *   )
     * )
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$user = User::find($id)) {
            return $this->errorResponse(404);
        }

        return response()->json($user, 200);
    }

    /**
     * @OA\Patch(
     *     tags={"user"},
     *     path="/api/users/{id}",
     *     summary="Update user",
     *     security={
     *       {"api_key": {}}
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         required=true,
     *         in="path",
     *         description="The user id",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Updated user object",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="street", format="string", type="string"),
     *                 @OA\Property(property="city", format="string", type="string"),
     *                 @OA\Property(property="state", format="string", type="string"),
     *                 @OA\Property(property="zip_code", format="string", type="string"),
     *                 @OA\Property(property="phone", format="string", type="string"),
     *            ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successfully updated",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized",
     *         @OA\JsonContent(@OA\Property(
     *         property="message",
     *         example="Unauthorized.",
     *         type="string")
     *     )
     *   ),
     *   @OA\Response(
     *       response="404",
     *       description="Not found",
     *       @OA\JsonContent(
     *           @OA\Property(property="message", example="User not found", type="string"))
     *   ),
     *   @OA\Response(
     *       response="422",
     *       description="Validation failed",
     *       @OA\JsonContent(
     *           @OA\Property(property="message", example="The given data was invalid.", type="string"),
     *           @OA\Property(property="errors",
     *               type="array",
     *               @OA\Items(
     *                   @OA\Property(
     *                       property="street",
     *                       example="Street must be at least 5 characters.",
     *                       type="string"
     *                   ),
     *                   @OA\Property(property="city", example="City must be at least 5 characters.", type="string"),
     *                   @OA\Property(property="zip_code", example="Zip must be at least 5 characters.", type="string"),
     *                   @OA\Property(property="state", example="State must be at least 5 characters.", type="string"),
     *                   @OA\Property(property="phone", example="Phone must be at least 5 characters.", type="string"),
     *               )
     *           ),
     *       )
     *   ),
     *   @OA\Response(
     *       response="500",
     *       description="Server error"
     *   )
     * )
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
           'street' => 'min:2|max:100',
           'city' => 'min:2|max:100',
           'zip_code' => 'min:5|max:10',
           'state' => 'min:2|max:15',
           'phone' => 'min:9|max:19'
        ]);

        if (!$user = User::find($id)) {
            return $this->errorResponse(404);
        }

        $user->update($request->only([
            'street',
            'city',
            'zip_code',
            'state',
            'phone'
        ]));

        return response()->json($user, 200);
    }

    /**
     * @OA\Delete(
     *     tags={"user"},
     *     path="/api/users/{id}",
     *     summary="Delete user",
     *     security={
     *       {"api_key": {}}
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         required=true,
     *         in="path",
     *         description="The user id",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successfully updated",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized",
     *         @OA\JsonContent(@OA\Property(
     *         property="message",
     *         example="Unauthorized.",
     *         type="string")
     *     )
     *   ),
     *   @OA\Response(
     *       response="404",
     *       description="Not found",
     *       @OA\JsonContent(
     *           @OA\Property(property="message", example="User not found", type="string"))
     *   ),
     *   @OA\Response(
     *       response="500",
     *       description="Server error"
     *   )
     * )
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$user = User::find($id)) {
            $user->delete();
            return response()->json($user, 200);
        }

        return $this->errorResponse(404);
    }

    private function errorResponse($code)
    {
        switch ($code) {
            case 404:
                return response()->json(['message' => 'User not found'], 404);
        }
    }
}
