<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Controller berdasarkan role
//admin
Route::middleware(['auth', 'role:admin'])->get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

//staff
Route::middleware(['auth', 'role:staff'])->get('/staff/dashboard', [StaffController::class, 'index'])->name('staff.dashboard');
Route::middleware(['auth', 'role:staff'])->get('/staff/tambah', [StaffController::class, 'tambah'])->name('staff.tambah');
Route::middleware(['auth', 'role:staff'])->post('/staff/tambah', [StaffController::class, 'store'])->name('staff.store');
Route::middleware(['auth', 'role:staff'])->get('/staff/edit/{id}', [StaffController::class, 'edit'])->name('staff.edit');
Route::middleware(['auth', 'role:staff'])->post('/staff/edit/{id}', [StaffController::class, 'update'])->name('staff.update');
Route::middleware(['auth', 'role:staff'])->get('/staff/update-status/{id}', [StaffController::class, 'updateStatus'])->name('staff.updateStatus');
Route::middleware(['auth', 'role:staff'])->get('/staff/reschedule', [StaffController::class, 'reschedule'])->name('staff.reschedule');
Route::middleware(['auth', 'role:staff'])->get('/staff/kunjungan', [StaffController::class, 'kunjungan'])->name('staff.kunjungan');
Route::middleware(['auth', 'role:staff'])->get('/staff/reservasi', [StaffController::class, 'reservasi'])->name('staff.reservasi');
Route::middleware(['auth', 'role:staff'])->get('/staff/saran', [StaffController::class, 'saran'])->name('staff.saran');

//user
Route::middleware(['auth', 'role:user'])->get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
Route::middleware(['auth', 'role:user'])->get('/user/reservasi', [UserController::class, 'reservasi'])->name('user.reservasi');
Route::middleware(['auth', 'role:user'])->get('/user/kunjungan', [UserController::class, 'kunjungan'])->name('user.kunjungan');
Route::middleware(['auth', 'role:user'])->post('/user/store', [UserController::class, 'store'])->name('user.store');
Route::middleware(['auth', 'role:user'])->get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
Route::middleware(['auth', 'role:user'])->post('/user/edit/{id}', [UserController::class, 'update'])->name('user.update');

