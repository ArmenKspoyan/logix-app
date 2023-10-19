<?php


namespace App\Repositories\Contracts\User;

interface IUserRepository
{

    public function getByEmail($email);

    public function createNewUser($attributes);

}
