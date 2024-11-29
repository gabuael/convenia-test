<?php

namespace App\Repositories\Auth;

use App\Models\User;
use App\Repositories\Contracts\Auth\AuthRepositoryInterface;

class AuthRepository implements AuthRepositoryInterface
{
    public function login(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}