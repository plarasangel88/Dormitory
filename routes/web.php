<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\MaintenanceController as AdminMaintenanceController;
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

// ---- Maintenance (student) ----
Route::get('/maintenance', [MaintenanceController::class, 'index'])
    ->middleware('auth')
    ->name('maintenance.index');

Route::get('/maintenance/create', [MaintenanceController::class, 'create'])
    ->middleware('auth')
    ->name('maintenance.create');

Route::post('/maintenance', [MaintenanceController::class, 'store'])
    ->middleware('auth')
    ->name('maintenance.store');

Route::get('/maintenance/{maintenance}', [MaintenanceController::class, 'show'])
    ->middleware('auth')
    ->name('maintenance.show');


Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('admin.dashboard');

        // ---- Students ----
        Route::get('/students', [StudentController::class, 'index'])
            ->name('admin.students.index');

        Route::post('/students', [StudentController::class, 'store'])
            ->name('admin.students.store');

        Route::put('/students/{student}', [StudentController::class, 'update'])
            ->name('admin.students.update');

        Route::delete('/students/{student}', [StudentController::class, 'destroy'])
            ->name('admin.students.destroy');

        // ---- Rooms ----
        Route::get('/rooms', [AdminRoomController::class, 'index'])
            ->name('admin.rooms.index');

        Route::post('/rooms', [AdminRoomController::class, 'store'])
            ->name('admin.rooms.store');

        Route::put('/rooms/{room}', [AdminRoomController::class, 'update'])
            ->name('admin.rooms.update');

        Route::delete('/rooms/{room}', [AdminRoomController::class, 'destroy'])
            ->name('admin.rooms.destroy');

        // ---- Payments ----
        Route::get('/payments', [AdminPaymentController::class, 'index'])
            ->name('admin.payments.index');

        Route::post('/payments', [AdminPaymentController::class, 'store'])
            ->name('admin.payments.store');

        Route::put('/payments/{payment}', [AdminPaymentController::class, 'update'])
            ->name('admin.payments.update');

        Route::delete('/payments/{payment}', [AdminPaymentController::class, 'destroy'])
            ->name('admin.payments.destroy');

        // ---- Maintenance ----
        Route::get('/maintenance', [AdminMaintenanceController::class, 'index'])
            ->name('admin.maintenance.index');

        Route::get('/maintenance/{maintenance}', [AdminMaintenanceController::class, 'show'])
            ->name('admin.maintenance.show');

        Route::put('/maintenance/{maintenance}', [AdminMaintenanceController::class, 'update'])
            ->name('admin.maintenance.update');

        Route::delete('/maintenance/{maintenance}', [AdminMaintenanceController::class, 'destroy'])
            ->name('admin.maintenance.destroy');

    });