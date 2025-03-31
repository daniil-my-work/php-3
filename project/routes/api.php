<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// ==> Роуты приложения <==
// => Auth
Route::prefix('auth')
    ->name('auth.')
    ->group(function () {
        Route::post('register', [AuthController::class, 'register'])->name('register');
        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::post('logout', [AuthController::class, 'logout'])
            ->middleware('auth:sanctum')
            ->name('logout');
    });

// => User
Route::controller(UserController::class)
    ->prefix('user')
    ->name('user.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('/', 'show')->name('show');
        Route::patch('/', 'update')->name('update');
    });

// => Film
Route::controller(FilmController::class)
    ->prefix('films')
    ->name('films.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}/similar', 'similar')->name('similar');

        Route::middleware('auth:sanctum')
            ->group(function () {
                Route::post('/', 'store')->name('store');
                Route::get('{id}', 'show')->name('show');
                Route::patch('{id}', 'update')->name('update');
            });
    });


// => Genre
Route::controller(GenreController::class)
    ->prefix('genres')
    ->name('genres.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::patch('{id}', 'update')->middleware('auth:sanctum')->name('update');
    });

// => Favorite
Route::controller(FavoriteController::class)
    ->prefix('favorite')
    ->name('favorite.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('{id}', 'store')->name('store');
        Route::delete('{id}', 'destroy')->name('destroy');
    });

// => Comment
Route::controller(CommentController::class)
    ->prefix('comments')
    ->name('comments.')
    ->group(function () {
        Route::get('{id}', 'index')->name('index');

        Route::middleware('auth:sanctum')
            ->group(function () {
                Route::post('{id}', 'store')->name('store');
                Route::patch('{id}', 'update')->name('update');
                Route::delete('{id}', 'destroy')->name('destroy');
            });
    });

// => Promo
Route::controller(PromoController::class)
    ->prefix('promo')
    ->name('promo.')
    ->group(function () {
        Route::get('/', 'show')->name('show');
        Route::post('{id}', 'store')->middleware('auth:sanctum')->name('store');
    });


// => MY TEST Routes
Route::get('/test', [TestController::class, 'index'])->name('test.index');
Route::get('/test/store/{id}', [TestController::class, 'storeFilm'])->name('test.store');
