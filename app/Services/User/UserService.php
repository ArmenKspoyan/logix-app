<?php

namespace App\Services\User;

use App\Repositories\Contracts\User\IUserRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{

    /**
     * @var IUserRepository
     */
    protected IUserRepository $userRepository;

    /**
     * AuthRepository constructor.
     * @param IUserRepository $userRepository
     */
    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     */
    public function changePassword($data)
    {
        return $this->userRepository->update(auth()->user()->id, [
            'password' => Hash::make($data['password'])
        ]);
    }


}
