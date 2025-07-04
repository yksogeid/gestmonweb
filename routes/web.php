<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\Can;
use Inertia\Inertia;
use App\Http\Controllers\UserController;
use Spatie\Permission\Middlewares\RoleMiddleware;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

// Registrar el alias 'role' para el middleware de Spatie
app('router')->aliasMiddleware('role', \Spatie\Permission\Middleware\RoleMiddleware::class);
// Protejo rutas por rol
// Para rol super-admin
Route::middleware(['role:admin|super-admin'])->group(function () {
    Route::get('/users', [RegisteredUserController::class, 'index'])->name('index');
    Route::post('/users', [RegisteredUserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}/role', [RegisteredUserController::class, 'updateRole']);
});

// Para rol student
Route::middleware(['role:student|student'])->group(function () {
    Route::get('/carreras', function () {
        return Inertia::render('carrera/index');
    })->name('index');
});

/// Para cualquier usuario autenticado
Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
