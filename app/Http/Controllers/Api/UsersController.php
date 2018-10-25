<?php

namespace App\Http\Controllers\Api;

use App\Helpers\AwsHelper;
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

    /**
     * @var AwsHelper
     */
    private $awsHelper;

    public function __construct()
    {
        $this->usersRepository = new UsersRepository();
        $this->awsHelper = new AwsHelper();
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

        /**
         * A list of fields which requires status to be changed to profile pending
         */
        $fieldRequiresChangeStatus = [
            'full_name', 'email', 'address', 'phone'
        ];

        if ($user->status != \ConstUserStatus::APPROVED) {
            abort(403, 'Your account should be approved to do this action');
        }

        if ($request->hasAny($fieldRequiresChangeStatus) && $this->usersRepository->userPendingProfileUpdateRequest($user->id)) {
            abort(403, 'You have already sent a request for changing your profile. Please wait for approval');
        }

        $this->validate($request, [
            'full_name' => 'min:2|max:100',
            'email' => 'email|unique:users,email,' . $user->id,
            'address' => 'min:2|max:255',
            'phone' => 'min:9|max:19',
            'photo' => 'image|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            $user->update([
                'photo' => $this->awsHelper->replaceS3File(
                    $user->photo,
                    $request->file('photo'),
                    'users/' . $user->id
                ),
            ]);
        }

        $data = $request->only($fieldRequiresChangeStatus);

        if (!empty($data)) {
            if (!$this->usersRepository->updateProfile($user->id, $data)) {
                abort(500, 'Unable to send request to update your profile');
            }
        }

        $user->refresh();

        return $this->success([
            'updated' => true,
            'user' => $user,
        ]);
    }

    /**
     * Shows user current status
     * @return \Illuminate\Http\JsonResponse
     */
    public function status()
    {
        /**
         * @var User
         */
        $user = auth()->user();

        return $this->success([
            'status' => $user->status,
            'profileUpdateStatus' => $user->profileUpdateRequest ? $user->profileUpdateRequest->status : null,
        ], 201);
    }

    /**
     * Allows to resubmit profile for moderation
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
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

            'driving_license_front' => 'required|image',
            'driving_license_back' => 'required|image',
            'tlc_license_front' => 'required|image',
            'tlc_license_back' => 'required|image',
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

            $drivingLicense->front = $this->awsHelper->uploadToS3(
                $request->file('driving_license_front'),
                'users/driving_license/front_' . $user->id
            );

            $drivingLicense->back = $this->awsHelper->uploadToS3(
                $request->file('driving_license_back'),
                'users/driving_license/back_' . $user->id
            );

            $tlcLicense = new TLCLicense;

            $tlcLicense->front = $this->awsHelper->uploadToS3(
                $request->file('tlc_license_front'),
                'users/tlc_license/front_' . $user->id
            );

            $tlcLicense->back = $this->awsHelper->uploadToS3(
                $request->file('tlc_license_back'),
                'users/tlc_license/back_' . $user->id
            );

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
}
