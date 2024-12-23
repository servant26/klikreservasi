<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Controller berdasarkan role
//admin
Route::middleware(['auth', 'role:admin'])->get('/dashboard/admin', [AdminController::class, 'index'])->name('dashboard.admin');

//staff
Route::middleware(['auth', 'role:staff'])->get('/dashboard/staff', [StaffController::class, 'index'])->name('dashboard.staff');

//user
Route::middleware(['auth', 'role:user'])->get('/dashboard/user', [UserController::class, 'index'])->name('dashboard.user');

