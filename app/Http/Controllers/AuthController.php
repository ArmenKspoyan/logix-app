<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Services\Auth\RegisterService;

class AuthController extends Controller
{

    /**
     * @var RegisterService
     */
    protected RegisterService $registerService;

    /**
     * AuthController constructor.
     * @param RegisterService $registerService
     */
    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function registration(RegisterRequest $request): ErrorResource|SuccessResource
    {
        return $this->registerService->register($request->validated());
    }

}
