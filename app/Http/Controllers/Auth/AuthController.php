<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }
    public function login(LoginRequest $request)
    {
        $loginData = $this->authService->login($request->email, $request->password);
        return response($loginData['response'], $loginData['status']);
    }
}
