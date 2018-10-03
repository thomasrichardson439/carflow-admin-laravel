<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DrivingLicense;
use App\Models\TLCLicense;
use App\Models\User;
use DB;
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
            'address' => 'min:2|max:255',
            'phone' => 'min:9|max:19',
            'photo' => 'image|max:2048'
        ]);

        if (!$user = User::find($id)) {
            return $this->errorResponse(404);
        }

        $data = $request->only([
            'address',
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function status()
    {
        $user = auth()->user();

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

    public function reSubmit(Request $request)
    {
        if (auth()->user()->status != \ConstUserStatus::REJECTED) {
            return response()->json(['error' => 'You are not allowed to do this action'], 403);
        }

        $this->validate($request, [
            'full_name' => 'required|min:2|max:100',
            'address' => 'required|min:2|max:255',
            'phone' => 'required|min:9|max:19',
            'ridesharing_approved' => 'required|boolean',
            'ridesharing_apps' => 'required|string',

            'driving_license_front' => 'required|string',
            'driving_license_back' => 'required|string',
            'tlc_license_front' => 'required|string',
            'tlc_license_back' => 'required|string',
        ]);

        DB::transaction(function () use ($request) {

            /**
             * @var $user User
             */
            $user = auth()->user();

            $user->full_name = $request->full_name;
            $user->address = $request->address;
            $user->phone = $request->phone;
            $user->status = \ConstUserStatus::PENDING;
            $user->save();

            $user->drivingLicense->delete();
            $user->tlcLicense->delete();

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
        });

        return response()->json([
            'user' => auth()->user(),
        ]);
    }
}
