<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Services\AuthService;


class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;

    }

    public function login(LoginRequest $request)
    {
        $token = $this->authService->login($request->email, $request->password);
        if (!$token)
            return response(['message' => 'invalid-credentials'], 422);
        return response(['token' => $token], 402);
    }

    public function logout(){
        $this->authService->logout();
        return response(['message'=>'logged-out'],402);
    }

}
