<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return "<h1>Используй путь: <a href='/api'>API</a></h1>";
});
