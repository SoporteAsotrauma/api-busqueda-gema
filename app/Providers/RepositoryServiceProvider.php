<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\FoxProRepositoryInterface;
use App\Repositories\FoxProRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(FoxProRepositoryInterface::class, FoxProRepository::class);
    }

    public function boot()
    {
        // No es necesario realizar configuraciones adicionales aquí.
    }
}
