<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\User;
use App\Services\class\client\LaravelHttpClient;
use App\Services\class\FilmRepository;
use App\Services\interfaces\IHttpClient;
use App\Services\interfaces\IRepository;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Связываем IHttpClient с конкретной реализацией (например, LaravelHttpClient)
        $this->app->bind(IHttpClient::class, LaravelHttpClient::class);

        // Связываем IRepository с FilmRepository
        $this->app->bind(IRepository::class, FilmRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('destroy_comment', function (User $user) {
            if ($user->isModerator()) {
                return true;
            }
        });

        Gate::define('update_comment', function (User $user, Comment $comment) {
            if ($user->isModerator()) {
                return true;
            }

            return $user->id === $comment->user_id;
        });
    }
}
