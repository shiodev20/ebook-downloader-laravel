<?php

namespace App\Providers;

use App\Models\Genre;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    Paginator::useBootstrapFour();

    Collection::macro('paginate', function ($perPage, $total = null, $page = null, $pageName = 'page') {
      $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

      return new LengthAwarePaginator(
        $total ? $this : $this->forPage($page, $perPage)->values(),
        $total ?: $this->count(),
        $perPage,
        $page,
        [
          'path' => LengthAwarePaginator::resolveCurrentPath(),
          'pageName' => $pageName,
        ]
      );
    });

    view()->composer('client.*', function($view) {
      $view->with('genres', Genre::all());
    });
  }
}
