<?php

namespace App\Repositories;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class BaseRepository
{
    /**
     * @var \Eloquent|Model
     */
    protected $model;

    /**
     * @param array $data
     * @return array
     */
    public function create(array $data) : array
    {
        $model = $this->model->create($data);

        /**
         * Added in order to reload relations on newly created models
         */
        $model = $this->model->find($model->getKey());

        return $this->show(
            $model
        );
    }

    /**
     * @param \Eloquent|Model $model
     * @param array $data
     * @return array
     */
    public function update($model, array $data) : array
    {
        $model->update($data);
        return $this->show($model);
    }

    /**
     * @param $id
     * @return int - amount of deleted rows
     */
    public function delete($id) : int
    {
        return $this->model->destroy($id);
    }

    /**
     * Prepare entity for showing
     * @param \Eloquent|Model $model
     * @return array
     */
    public function show($model) : array
    {
        if (!$model) {
            throw new NotFoundHttpException('Entity not found');
        }

        $data = $model->toArray();

        // Convert dates to api format before show:
        foreach ($model->getDates() as $dateKey) {
            if (!isset($data[$dateKey])) {
                continue;
            }

            $data[$dateKey] = dateResponseFormat($model->getAttribute($dateKey));
        }

        return $data;
    }

    /**
     * Allows to find and show entity by id
     * @param $id
     * @return array
     */
    public function findAndShow($id) : array
    {
        return $this->show(
            $this->model->find($id)
        );
    }
}