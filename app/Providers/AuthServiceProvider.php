<?php

namespace App\Providers;

use App\Enums\RoleEnum;
use App\Models\Review;
use App\Models\User;
use App\Policies\ReviewPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use function PHPUnit\Framework\isNull;

class AuthServiceProvider extends ServiceProvider
{
  /**
   * The model to policy mappings for the application.
   *
   * @var array<class-string, class-string>
   */
  protected $policies = [
    Review::class => ReviewPolicy::class,
  ];

  /**
   * Register any authentication / authorization services.
   */
  public function boot(): void
  {
    Gate::define('download', function (User $user) {
      return isset($user);
    });

    Gate::define('is-masterAdmin', function (User $user) {
      return $user->role_id === RoleEnum::MASTER_ADMIN->value;
    });

    Gate::define('is-admin', function (User $user) {
      return $user->role_id === RoleEnum::MASTER_ADMIN->value || $user->role_id === RoleEnum::ADMIN->value;
    });

    Gate::define('is-member', function (User $user) {
      return $user->role_id === RoleEnum::MEMBER->value;
    });
    
    Gate::define('create-review', [ReviewPolicy::class, 'create']);
    Gate::define('update-review', [ReviewPolicy::class, 'update']);
    Gate::define('delete-review', [ReviewPolicy::class, 'delete']);
  }
}
