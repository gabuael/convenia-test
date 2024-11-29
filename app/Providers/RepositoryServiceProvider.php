<?php

namespace App\Providers;

use App\Repositories\Auth\AuthRepository;
use App\Repositories\Contracts\Auth\AuthRepositoryInterface;
use Illuminate\Support\ServiceProvider;
class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
    }
}