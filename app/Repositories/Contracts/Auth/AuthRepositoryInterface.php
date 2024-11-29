<?php

namespace App\Repositories\Contracts\Auth;

use App\Models\User;

interface AuthRepositoryInterface
{
    public function login(string $email): ?User;
}