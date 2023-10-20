<?php

namespace App\Services\Auth;

use App\Http\Resources\Auth\LoginResource;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Repositories\Contracts\User\IUserRepository;
use Illuminate\Support\Facades\Auth;

class RegisterService
{

    /**
     * AuthRepository constructor.
     * @param IUserRepository $userRepository
     */
    public function __construct(private readonly IUserRepository $userRepository)
    {
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

    public function login($data): ErrorResource|SuccessResource
    {
        $user = $this->userRepository->getByEmail($data['email']);

        if (!Auth::attempt($data)) {
            return ErrorResource::make([
                'success' => false,
                'message' => trans('Incorrect email or password')
            ]);
        }

        $result['user'] = $user;
        $result['token'] = $user->createToken('appToken')->accessToken;
        return SuccessResource::make([
//            'data' => LoginResource::make($result),
            'data' => $result,
            'success' => true,
            'message' => trans('User login successfully')
        ]);

    }

}
