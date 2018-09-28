<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Storage;

/**
 * Class UsersController
 * @package App\Http\Controllers\Api
 */
class UsersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'street' => 'min:2|max:100',
            'city' => 'min:2|max:100',
            'zip_code' => 'min:5|max:10',
            'state' => 'min:2|max:15',
            'phone' => 'min:9|max:19',
            'photo' => 'image|max:2048'
        ]);

        if (!$user = User::find($id)) {
            return $this->errorResponse(404);
        }

        $data = $request->only([
            'street',
            'city',
            'zip_code',
            'state',
            'phone'
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = Storage::url(
                $request->photo->store('user/images/' . $user->id)
            );
        }

        $user->update($data);

        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($user = User::find($id)) {
            $user->delete();
            return response()->json($user);
        }

        return $this->errorResponse(404);
    }

    /**
     * Return error response for specified code
     *
     * @param  int $code
     * @return \Illuminate\Http\Response
     */
    private function errorResponse($code)
    {
        switch ($code) {
            case 404:
                return response()->json(['message' => 'User not found'], 404);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkUserStatus($id)
    {
        $user = User::find($id, ['status']);
        if (empty($user)) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json([
            'advanced_message' => $this->getAdvancedMessage($user->status),
            'message' => 'User status is ' . $user->status,
            'status' => $user->status
        ], 201);
    }

    /**
     * @param $status
     * @return string
     */
    public function getAdvancedMessage($status)
    {
        if ($status == \ConstUserStatus::PENDING) {
            return 'Pending approval';
        }
        if ($status == \ConstUserStatus::APPROVED) {
            return 'Approved';
        }
        if ($status == \ConstUserStatus::REJECTED) {
            return 'Not approved/Regular';
        }
        return '@TODO';
    }
}
