<?php

namespace App\Providers;

use BaseRepositoryInterface;
use Contracts\BaseRepository;
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
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(TaskRepository::class, TaskRepositoryInterface::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
