<?php

namespace App\Providers;

use App\Repository\AuthorRepository;
use App\Repository\GenreRepository;
use App\Repository\IRepository;
use App\Repository\PublisherRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(IRepository::class, GenreRepository::class);
        $this->app->bind(IRepository::class, AuthorRepository::class);
        $this->app->bind(IRepository::class, PublisherRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
