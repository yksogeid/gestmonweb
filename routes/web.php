<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\Can;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::middleware(['can:ver libros'])->group(function () {
    Route::get('/users', function () {
        return Inertia::render('users/index');
    })->name('index');
    Route::get('/carreras', function () {
        return Inertia::render('carrera/index');
    })->name('index');
});


Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
