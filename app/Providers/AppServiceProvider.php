<?php

namespace App\Providers;

use App\Models\Repo\IServicesRepository;
use App\Models\Repo\ServicesRepository;
use App\Models\Repo\UserRepository;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IServicesRepository::class, ServicesRepository::class);
        $this->app->bind(IServicesRepository::class, UserRepository::class);

        // $this->app->scoped(IServicesRepository::class, ServicesRepository::class);
        // $this->app->scoped(IServicesRepository::class, UserRepository::class);
        // $this->app->scoped(ServicesRepository::class, UserRepository::class);
        // $this->app->scoped(UserRepository::class, function ($app) {
        //     return new UserRepository(new User());
        // });
    }
    

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
