<?php

namespace App\Providers;

use App\Models\Repo\IServicesRepository;
use App\Models\Repo\ServicesRepository;
use App\Models\Repo\UserRepository;
use App\Models\RepositorySQL\IServicesRepositorySQL;
use App\Models\RepositorySQL\ServicesRepositorySQL;
use App\Models\RepositorySQL\UserRepositorySQL;
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

        $this->app->bind(IServicesRepositorySQL::class,ServicesRepositorySQL::class);
        $this->app->bind(IServicesRepositorySQL::class,UserRepositorySQL::class);

    }
    

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
