<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\ChangeEmailConfirmRequest;
use App\Http\Requests\User\ChangeEmailRequest;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Repositories\Contracts\User\IUserRepository;
use App\Services\User\UserService;


class UserController extends Controller
{

    /**
     * @var UserService
     */
    protected UserService $userService;

    /**
     * @var IUserRepository
     */
    protected IUserRepository $userRepository;

    /**
     * UserController constructor.
     * @param UserService $userService
     * @param IUserRepository $userRepository
     */
    public function __construct(
        UserService     $userService,
        IUserRepository $userRepository,
    )
    {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
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

    public function resetPasswordLink(): SuccessResource|ErrorResource
    {
        $user = $this->userRepository->find(auth()->user()->id);
        if (!$user) {
            return ErrorResource::make([
                'success' => false,
                'message' => trans('Something went wrong')
            ]);
        }

        $result = $this->userService->resetPasswordLink();
        if (!$result) {
            return ErrorResource::make([
                'success' => false,
                'message' => trans('Something went wrong')
            ]);
        }
        return SuccessResource::make([
            'success' => true,
            'message' => trans('Password reset link has been sent to your email')
        ]);

    }

    public function changeEmail(ChangeEmailRequest $request): SuccessResource|ErrorResource
    {
        $this->userService->changeEmail($request->validated());
        return SuccessResource::make([
            'message' => 'Link for change email successfully sent'
        ]);
    }

    public function changeEmailConfirm(ChangeEmailConfirmRequest $request): SuccessResource
    {
        $this->userService->changeEmailConfirm($request->validated());
        return SuccessResource::make([
            'message' => 'Email changed',
        ]);
    }

}
