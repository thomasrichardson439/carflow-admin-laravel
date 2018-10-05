<?php

namespace App\Http\Controllers\Api;

use App\Models\DrivingLicense;
use App\Models\TLCLicense;
use App\Models\User;
use App\Repositories\UsersRepository;
use Aws\S3\S3Client;
use DB;
use Illuminate\Http\Request;

/**
 * Class UsersController
 * @package App\Http\Controllers\Api
 */
class UsersController extends BaseApiController
{
    /**
     * @var UsersRepository
     */
    private $usersRepository;

    public function __construct()
    {
        $this->usersRepository = new UsersRepository();
    }

    /**
     * Allows to get authenticated user info
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        /**
         * @var $user User
         */
        $user = auth()->user();

        return $this->success([
            'user' => $this->usersRepository->show($user)
        ]);
    }

    /**
     * Updates authenticated user
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        /**
         * @var $user User
         */
        $user = auth()->user();

        $this->validate($request, [
            'full_name' => 'min:2|max:100',
            'email' => 'email|unique:users,email,' . $user->id,
            'address' => 'min:2|max:255',
            'phone' => 'min:9|max:19',
            'photo' => 'image|max:2048'
        ]);

        $data = $request->only([
            'full_name',
            'email',
            'address',
            'phone'
        ]);

        if ($request->hasFile('photo')) {

            /**
             * @var $client S3Client
             */
            $client = \App::make('aws')->createClient('s3');

            $photo = $request->file('photo');

            $data['photo'] = $client->putObject([
                'Bucket'     => getenv('AWS_BUCKET'),
                'Key'        => 'users/' . getenv('APP_ENV') . $user->id . '.' . $photo->extension(),
                'SourceFile' => $photo->getPathName(),
            ])['ObjectURL'];
        }

        return $this->success([
            'user' => $this->usersRepository->update($user, $data)
        ]);
    }

    /**
     * Shows user current status
     * @return \Illuminate\Http\JsonResponse
     */
    public function status()
    {
        $user = auth()->user();

        return $this->success([
            'advanced_message' => $this->getAdvancedMessage($user->status),
            'message' => 'User status is ' . $user->status,
            'status' => $user->status
        ], 201);
    }

    /**
     * Allows to resubmit profile for moderation
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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

        return $this->success([
            'user' => auth()->user(),
        ]);
    }

    /**
     * @param $status
     * @return string
     */
    private function getAdvancedMessage($status)
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
