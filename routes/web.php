<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Student\ProfileController;
use App\Http\Controllers\Student\PaymentController;
use App\Http\Controllers\Student\RoomController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
})->name('logout');


// ===============================
// STUDENT ROUTES
// ===============================

Route::get('/dashboard', function () {
    return view('student.dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/profile', [ProfileController::class, 'index'])
    ->middleware('auth')
    ->name('profile');

Route::post('/profile', [ProfileController::class, 'update'])
    ->middleware('auth')
    ->name('profile.update');

Route::get('/room', [RoomController::class, 'index'])
    ->middleware('auth')
    ->name('room');

Route::get('/payments', [PaymentController::class, 'index'])
    ->middleware('auth')
    ->name('payments');

Route::post('/payments', [PaymentController::class, 'store'])
    ->middleware('auth')
    ->name('payments.store');


// ===============================
// ADMIN ROUTES
// ===============================

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('admin.dashboard');

    });
