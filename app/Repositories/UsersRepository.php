<?php

namespace App\Repositories;

use App\Models\User;

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

    public function show($model): array
    {
        return array_merge(
            parent::show($model),
            [
                'created_at' => dateResponseFormat($model->created_at),
                'updated_at' => dateResponseFormat($model->updated_at),
            ]
        );
    }
}