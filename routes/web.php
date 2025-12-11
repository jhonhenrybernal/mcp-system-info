<?php

use Illuminate\Support\Facades\Route;

// Página de documentación Swagger (L5-Swagger)
Route::get('/docs', function () {
    return view('l5-swagger::index');
})->name('api.docs');
Route::get('/', function () {
    return view('welcome');
});
