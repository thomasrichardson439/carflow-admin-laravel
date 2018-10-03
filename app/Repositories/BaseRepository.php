<?php

namespace App\Repositories;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class BaseRepository
{
    /**
     * @var \Eloquent
     */
    protected $model;

    /**
     * @param array $data
     * @return \Eloquent
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @param $id
     * @return \Eloquent
     */
    public function update(array $data, $id)
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);

        return $model;
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
     * @param $id
     * @return array
     */
    public function show($id) : array
    {
        $model = $this->model->find($id);

        if (!$model) {
            throw new NotFoundHttpException('Entity not found');
        }

        return $model->toArray();
    }
}