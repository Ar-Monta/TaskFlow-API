<?php

namespace App\Providers;

use App\Services\Contracts\TaskServiceInterface;
use App\Services\TaskService;
use BaseRepository;
use Contracts\BaseRepositoryInterface;
use Contracts\TaskRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use TaskRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->singleton(TaskRepositoryInterface::class, TaskRepository::class);
        $this->app->singleton(TaskServiceInterface::class, TaskService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
