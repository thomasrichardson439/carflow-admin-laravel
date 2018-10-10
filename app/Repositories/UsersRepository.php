<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserProfileUpdate;

class UsersRepository extends BaseRepository
{
    /**
     * @var User
     */
    protected $model;

    public function __construct()
    {
        $this->model = new User();
    }

    /**
     * Allows to store profile update request
     * @param int $userId
     * @param array $data
     * @return bool
     */
    public function updateProfile(int $userId, array $data) : bool
    {
        $model = new UserProfileUpdate();

        $model->user_id = $userId;
        $model->status = 'pending';

        $model->fill($data);

        return $model->save();
    }

    /**
     * Allows to check if user has pending profile update request
     * @param int $userId
     * @return bool
     */
    public function userPendingProfileUpdateRequest(int $userId) : bool
    {
        return UserProfileUpdate::query()
            ->where('user_id', $userId)
            ->where('status', UserProfileUpdate::STATUS_PENDING)
            ->exists();
    }
}