<?php

namespace App\Services\User;

use App\Mail\ChangeEmail;
use App\Mail\ResetPassword;
use App\Repositories\Contracts\User\IUserRepository;
use Illuminate\Mail\SentMessage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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

    public function resetPasswordLink(): ?SentMessage
    {
        $token = Str::random(64);
        $this->userRepository->update(auth()->user()->id, [
            'token' => $token,
        ]);
        return Mail::to(auth()->user()->email)->send(new ResetPassword($token));
    }

    public function changeEmail($data): void
    {
        $user = $this->userRepository->find(auth()->user()->id);
        $email = $data['email'];

        $token = Str::random(64);
        if ($user) {
            $this->userRepository->update(auth()->user()->id, [
                'token' => $token,
                'email' => $email,
            ]);
            Mail::to($email)->send(new ChangeEmail([
                'token' => $token,
                'email' => $email,
            ]));
        }
    }

    public function changeEmailConfirm($data): void
    {
        $user = $this->userRepository->find(auth()->user()->id);
        if ($user) {
            $this->userRepository->update(auth()->user()->id, [
                'email' => $data['email']
            ]);
        }

    }


}
