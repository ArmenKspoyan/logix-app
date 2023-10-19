<?php

namespace App\Repositories;

use App\Repositories\Contracts\BaseRepository as BaseRepositoryContract;

abstract class BaseRepository implements BaseRepositoryContract
{
    protected mixed $model;

    /** BaseRepository constructor. */
    public function __construct(mixed $model = null)
    {
        $this->model = $model;
    }

    public function create(array $attributes): mixed
    {
        return $this->model->create($attributes);
    }

    public function delete(int $id): mixed
    {
        return $this->model->find($id)->delete();
    }

    public function find(int $id): mixed
    {
        return $this->model->find($id);
    }

    public function update(int $id, array $attributes): mixed
    {
        return $this->model->find($id)->update($attributes);
    }
}
