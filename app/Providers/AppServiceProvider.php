<?php

namespace App\Providers;

use App\Models\Repo\IServicesRepository;
use App\Models\Repo\ServicesRepository;
use App\Models\Repo\UserRepository;
use App\Models\RepositorySQL\CommintRepositorySQL;
use App\Models\RepositorySQL\CommintService;
use App\Models\RepositorySQL\IServicesRepositorySQL;
use App\Models\RepositorySQL\PostRepositorySQL;
use App\Models\RepositorySQL\PostService;
use App\Models\RepositorySQL\ServicesRepositorySQL;
use App\Models\RepositorySQL\UserRepositorySQL;
use App\Models\RepositorySQL\UserService;
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
        $this->app->bind(IServicesRepositorySQL::class, ServicesRepositorySQL::class);

        $this->app->bind(UserRepositorySQL::class, function ($app) {
            return new UserRepositorySQL();
        });

        $this->app->bind(PostRepositorySQL::class, function ($app) {
            return new PostRepositorySQL();
        });
        $this->app->bind(CommintRepositorySQL::class, function ($app) {
            return new CommintRepositorySQL();
        });
        $this->app->singleton(UserService::class, function ($app) {
            return new UserService($app->make(UserRepositorySQL::class));
        });

        $this->app->singleton(PostService::class, function ($app) {
            return new PostService($app->make(PostRepositorySQL::class));
        });
        $this->app->singleton(CommintService::class, function ($app) {
            return new CommintService($app->make(CommintRepositorySQL::class));
        });
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);
        require base_path('routes/channels.php');
    }
}
