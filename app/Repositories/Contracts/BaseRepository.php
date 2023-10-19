<?php

namespace App\Repositories\Contracts;

/**
 * Interface BaseRepositoryInterface.
 */
interface BaseRepository
{
    public function create(array $attributes): mixed;

    public function delete(int $id): mixed;

    public function find(int $id): mixed;

    public function update(int $id, array $attributes): mixed;

}
