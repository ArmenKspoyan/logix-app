<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\User\IUserRepository;

class UserRepository extends BaseRepository implements IUserRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function createNewUser($attributes)
    {
        return $this->model::create([
            'email' => $attributes['email'],
            'name' => $attributes['name'],
            'last_name' => $attributes['last_name'],
            'password' => bcrypt($attributes['password'])
        ]);

    }

}
