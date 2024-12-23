<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard berdasarkan role
Route::middleware(['auth', 'role:admin'])->get('/dashboard/admin', function () {
    return view('dashboard.admin');
})->name('dashboard.admin');

Route::middleware(['auth', 'role:staff'])->get('/dashboard/staff', function () {
    return view('dashboard.staff');
})->name('dashboard.staff');

Route::middleware(['auth', 'role:user'])->get('/dashboard/user', function () {
    return view('dashboard.user');
})->name('dashboard.user');

