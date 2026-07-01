<?php

namespace App\Providers;

use App\Repositories\Eloquent\TaskRepository;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);

        // to bind ProductRepositoryInterface to ProductRepository,
        // $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
    }
}