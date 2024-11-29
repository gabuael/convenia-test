<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Repositories\Auth\AuthRepository;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function __construct(private AuthRepository $authRepository)
    {

    }

    public function login(string $email, string $password)
    {
        $user = User::where('email', $email)->first();
        if ($user && Hash::check($password, $user->password)) {
            $token = $user->createToken('Password')->accessToken;
            return ["response" => ['token' => $token], "status" => 200];
        }

        return ["response" => ["message" => "Invalid password or email"], "status" => 422];
    }
}