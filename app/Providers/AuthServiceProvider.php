<?php

namespace App\Providers;

use App\Enums\RoleEnum;
use App\Models\Genre;
use App\Models\User;
use App\Policies\GenrePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('is-masterAdmin', function(User $user) {
            return $user->role_id === RoleEnum::MASTER_ADMIN->value;
        });

        Gate::define('is-admin', function(User $user) {
            return $user->role_id === RoleEnum::MASTER_ADMIN->value || $user->role_id === RoleEnum::ADMIN->value;
        });
    }
}
