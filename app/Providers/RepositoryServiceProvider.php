<?php

namespace App\Providers;

use App\Repositories\Blog\BlogRepository;
use App\Repositories\Contracts\Blog\IBlogRepository;
use App\Repositories\Contracts\Image\IImageRepository;
use App\Repositories\Contracts\User\IUserRepository;
use App\Repositories\Image\ImageRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IBlogRepository::class, BlogRepository::class);
        $this->app->bind(IImageRepository::class, ImageRepository::class);

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
