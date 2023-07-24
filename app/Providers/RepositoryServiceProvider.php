<?php

namespace App\Providers;

use App\Repository\IRepository\IAuthorRepository;
use App\Repository\IRepository\IGenreRepository;
use App\Repository\IRepository\IPublisherRepository;
use App\Repository\IRepository\IBookRepository;
use App\Repository\GenreRepository;
use App\Repository\PublisherRepository;
use App\Repository\AuthorRepository;
use App\Repository\BookFileRepository;
use App\Repository\BookGenreRepository;
use App\Repository\BookRepository;
use App\Repository\FileTypeRepository;
use App\Repository\QuoteRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(IGenreRepository::class, GenreRepository::class);
        $this->app->bind(IAuthorRepository::class, AuthorRepository::class);
        $this->app->bind(IPublisherRepository::class, PublisherRepository::class);
        $this->app->bind(IBookRepository::class, BookRepository::class);
        $this->app->bind(IRepository::class, FileTypeRepository::class);
        $this->app->bind(IRepository::class, BookFileRepository::class);
        $this->app->bind(IRepository::class, BookGenreRepository::class);
        $this->app->bind(IRepository::class, QuoteRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}