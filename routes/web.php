<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Announcement;
use App\Models\MaintenanceRequest;

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Student\MaintenanceController;
use App\Http\Controllers\RoomTaskController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\BillController as AdminBillController;
use App\Http\Controllers\Admin\MaintenanceController as AdminMaintenanceController;
use App\Http\Controllers\Student\ProfileController;
use App\Http\Controllers\Student\PaymentController;
use App\Http\Controllers\Student\RoomController;


// ===============================
// GENERAL ROUTES
// ===============================

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
// FORGOT / RESET PASSWORD
// ===============================

Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])
    ->name('password.email');

Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])
    ->name('password.reset');

Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])
    ->name('password.update');


// ===============================
// STUDENT ROUTES
// ===============================

Route::get('/dashboard', function () {
    $user = Auth::user();
    $announcements = Announcement::with('author')
        ->feed()
        ->take(10)
        ->get();

    $room = $user->room;
    $payments = $user->payments;
    $bills = $user->bills()->with('payments')->get();
    if ($bills->isNotEmpty()) {
        $paymentStatus = $bills->sum(fn ($bill) => $bill->balance) <= 0.01
            ? 'Paid'
            : 'Balance Due';
    } else {
        $paymentStatus = $payments->contains('status', 'pending')
            ? 'Pending'
            : ($payments->contains('status', 'verified') ? 'Paid' : 'No bills');
    }
    $maintenanceCount = MaintenanceRequest::where('user_id', $user->id)->count();

    return view('student.dashboard', compact(
        'announcements',
        'room',
        'paymentStatus',
        'maintenanceCount'
    ));
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


// ---- Room Tasks (Student) ----

Route::post('/room/tasks', [RoomTaskController::class, 'store'])
    ->middleware('auth')
    ->name('room.tasks.store');

Route::patch('/room/tasks/{task}/toggle', [RoomTaskController::class, 'toggle'])
    ->middleware('auth')
    ->name('room.tasks.toggle');

Route::delete('/room/tasks/{task}', [RoomTaskController::class, 'destroy'])
    ->middleware('auth')
    ->name('room.tasks.destroy');


// ---- Student Payments ----

Route::get('/payments', [PaymentController::class, 'index'])
    ->middleware('auth')
    ->name('payments');

Route::post('/payments', [PaymentController::class, 'store'])
    ->middleware('auth')
    ->name('payments.store');

Route::get('/payments/receipt/{reference}', [PaymentController::class, 'receipt'])
    ->middleware('auth')
    ->name('payments.receipt');

Route::get('/payments/gcash-qr', [PaymentController::class, 'gcashQr'])
    ->middleware('auth')
    ->name('payments.gcash-qr');


// ---- Maintenance (Student) ----

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


// ===============================
// ADMIN ROUTES
// ===============================

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->group(function () {

        // ---- Admin Dashboard ----

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('admin.dashboard');


        // ---- Announcements ----

        Route::post('/announcements', [AnnouncementController::class, 'store'])
            ->name('admin.announcements.store');

        Route::post('/announcements/{announcement}/delete', [AnnouncementController::class, 'destroy'])
            ->name('admin.announcements.destroy');


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

        Route::get('/rooms/{room}', [AdminRoomController::class, 'show'])
            ->name('admin.rooms.show');

        Route::post('/rooms', [AdminRoomController::class, 'store'])
            ->name('admin.rooms.store');

        Route::put('/rooms/{room}', [AdminRoomController::class, 'update'])
            ->name('admin.rooms.update');

        Route::delete('/rooms/{room}', [AdminRoomController::class, 'destroy'])
            ->name('admin.rooms.destroy');


        // ---- Billing (Rent / Electricity / Water) ----

        Route::get('/bills', [AdminBillController::class, 'index'])
            ->name('admin.bills.index');

        Route::post('/bills', [AdminBillController::class, 'store'])
            ->name('admin.bills.store');

        Route::put('/bills/{bill}', [AdminBillController::class, 'update'])
            ->name('admin.bills.update');

        Route::delete('/bills/{bill}', [AdminBillController::class, 'destroy'])
            ->name('admin.bills.destroy');


        // ---- Admin Payments ----

        Route::get('/payments', [AdminPaymentController::class, 'index'])
            ->name('admin.payments.index');

        Route::post('/payments', [AdminPaymentController::class, 'store'])
            ->name('admin.payments.store');

        Route::put('/payments/{payment}', [AdminPaymentController::class, 'update'])
            ->name('admin.payments.update');

        Route::post('/payments/{payment}/verify', [AdminPaymentController::class, 'verify'])
            ->name('admin.payments.verify');

        Route::post('/payments/gcash-qr', [AdminPaymentController::class, 'updateGcashQr'])
            ->name('admin.payments.gcash-qr');

        Route::delete('/payments/{payment}', [AdminPaymentController::class, 'destroy'])
            ->name('admin.payments.destroy');


        // ---- Maintenance (Admin) ----

        Route::get('/maintenance', [AdminMaintenanceController::class, 'index'])
            ->name('admin.maintenance.index');

        Route::get('/maintenance/{maintenance}', [AdminMaintenanceController::class, 'show'])
            ->name('admin.maintenance.show');

        Route::put('/maintenance/{maintenance}', [AdminMaintenanceController::class, 'update'])
            ->name('admin.maintenance.update');

        Route::delete('/maintenance/{maintenance}', [AdminMaintenanceController::class, 'destroy'])
            ->name('admin.maintenance.destroy');

    });
