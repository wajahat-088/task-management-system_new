<?php

namespace App\Providers;

use App\Repositories\Eloquent\TaskRepository;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Eloquent\RoleRepository;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);   
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        // to bind ProductRepositoryInterface to ProductRepository,
        // $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
    }
}