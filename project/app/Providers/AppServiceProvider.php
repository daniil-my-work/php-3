<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
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
        Gate::define('delete-comment', function (User $user) {
            if ($user->role()->first()['role_value'] === 'moderator') {
                return true;
            }
        });

        Gate::define('edit-comment', function (User $user, Comment $comment) {
            if ($user->role->first()['role_value'] === 'moderator') {
                return true;
            }

            return $user->id === $comment->user_id;
        });
    }
}
