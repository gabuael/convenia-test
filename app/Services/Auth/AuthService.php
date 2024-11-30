<?php

namespace App\Services\Auth;

use App\Repositories\Contracts\Auth\AuthRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function __construct(private AuthRepositoryInterface $authRepository)
    {

    }

    public function login(string $email, string $password)
    {
        $user = $this->authRepository->login($email);
        if ($user && Hash::check($password, $user->password)) {
            return ["response" => ['token' => $user->createToken('Password')->accessToken], "status" => 200];
        }

        return ["response" => ["message" => "Invalid password or email"], "status" => 422];
    }
}