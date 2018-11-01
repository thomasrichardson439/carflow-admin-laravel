<?php

namespace App\Repositories;

use App\Models\Borough;

class BoroughsRepository extends BaseRepository
{
    /**
     * @var Borough
     */
    protected $model;

    public function __construct()
    {
        $this->model = new Borough();
    }

    /**
     * Allows to get a list of boroughs
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->model->query()->orderBy('name', 'ASC')->get();
    }

}