<?php

namespace App\Services\Auth;

use App\Exceptions\NotFoundException;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Repositories\Contracts\User\IUserRepository;

class RegisterService
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
    public function register($data): ErrorResource|SuccessResource
    {
        $user = $this->userRepository->getByEmail($data['email']);
        if ($user) {
            return ErrorResource::make([
                'success' => false,
                'message' => trans('User exists')
            ]);
        }

        $this->userRepository->createNewUser($data);
        return SuccessResource::make([
            'success' => true,
            'message' => trans('User created successfully')
        ]);
    }

}
