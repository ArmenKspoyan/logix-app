<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Password;
use Illuminate\Mail\Message;


class UserController extends Controller
{

    /**
     * @var UserService
     */
    protected UserService $userService;

    /**
     * AuthController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function changePassword(ChangePasswordRequest $request): SuccessResource|ErrorResource
    {
        $result = $this->userService->changePassword($request->validated());
        if (!$result) {
            return ErrorResource::make([
                'success' => false,
                'message' => trans('Something went wrong')
            ]);
        }
        return SuccessResource::make([
            'message' => 'Password changed',
        ]);

    }

}
