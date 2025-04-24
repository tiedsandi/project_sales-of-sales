<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Helpers\RoleHelper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::if('role', fn($role) => auth()->check() && RoleHelper::is($role));
        Blade::if('anyrole', fn($roles) => auth()->check() && RoleHelper::isAny((array) $roles));
    }
}
