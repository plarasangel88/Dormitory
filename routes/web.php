<?php

use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\BillController as AdminBillController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MaintenanceController as AdminMaintenanceController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MaintenanceMessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RoomTaskController;
use App\Http\Controllers\Student\MaintenanceController;
use App\Http\Controllers\Student\PaymentController;
use App\Http\Controllers\Student\ProfileController;
use App\Http\Controllers\Student\RoomController;
use App\Models\Announcement;
use App\Models\Bill;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth')->group(function () {
    Route::get('/notifications/feed', [NotificationController::class, 'index'])
        ->name('notifications.feed');

    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])
        ->name('notifications.read-all');

    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markRead'])
        ->name('notifications.read');
});

// ===============================
// FORGOT / RESET PASSWORD
// ===============================

Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])
    ->middleware('throttle:5,1')
    ->name('password.email');

Route::get('/verify-email-code', [ForgotPasswordController::class, 'showVerificationCodeForm'])
    ->name('email.verification.code.form');

Route::post('/verify-email-code', [ForgotPasswordController::class, 'verifyEmailCode'])
    ->middleware('throttle:5,1')
    ->name('email.verification.code');

Route::post('/verify-email-code/resend', [ForgotPasswordController::class, 'resendVerificationCode'])
    ->middleware('throttle:3,1')
    ->name('email.verification.code.resend');

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
    $paymentReminders = $bills->filter(fn (Bill $bill): bool => $bill->due_date !== null
        && $bill->due_date->lte(now()->addDays(7)->endOfDay())
        && $bill->reminderBalance() > 0
    );
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
        'maintenanceCount',
        'paymentReminders'
    ));
})->middleware(['auth', 'student'])->name('dashboard');

Route::get('/profile', [ProfileController::class, 'index'])
    ->middleware(['auth', 'student'])
    ->name('profile');

Route::post('/profile', [ProfileController::class, 'update'])
    ->middleware(['auth', 'student'])
    ->name('profile.update');

Route::get('/room', [RoomController::class, 'index'])
    ->middleware(['auth', 'student'])
    ->name('room');

// ---- Room Tasks (Student) ----

Route::post('/room/tasks', [RoomTaskController::class, 'store'])
    ->middleware(['auth', 'student'])
    ->name('room.tasks.store');

Route::patch('/room/tasks/{task}/toggle', [RoomTaskController::class, 'toggle'])
    ->middleware(['auth', 'student'])
    ->name('room.tasks.toggle');

Route::delete('/room/tasks/{task}', [RoomTaskController::class, 'destroy'])
    ->middleware(['auth', 'student'])
    ->name('room.tasks.destroy');

// ---- Student Payments ----

Route::get('/payments', [PaymentController::class, 'index'])
    ->middleware(['auth', 'student'])
    ->name('payments');

Route::post('/payments', [PaymentController::class, 'store'])
    ->middleware(['auth', 'student'])
    ->name('payments.store');

Route::get('/payments/receipt/{reference}', [PaymentController::class, 'receipt'])
    ->middleware(['auth', 'student'])
    ->name('payments.receipt');

Route::get('/payments/gcash-qr', [PaymentController::class, 'gcashQr'])
    ->middleware(['auth', 'student'])
    ->name('payments.gcash-qr');

// ---- Maintenance (Student) ----

Route::get('/maintenance', [MaintenanceController::class, 'index'])
    ->middleware(['auth', 'student'])
    ->name('maintenance.index');

Route::get('/maintenance/create', [MaintenanceController::class, 'create'])
    ->middleware(['auth', 'student'])
    ->name('maintenance.create');

Route::post('/maintenance', [MaintenanceController::class, 'store'])
    ->middleware(['auth', 'student'])
    ->name('maintenance.store');

Route::post('/maintenance/{maintenance}/messages', [MaintenanceMessageController::class, 'store'])
    ->middleware('auth')
    ->name('maintenance.messages.store');

Route::get('/maintenance/{maintenance}', [MaintenanceController::class, 'show'])
    ->middleware(['auth', 'student'])
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

        Route::get('/reports', [ReportController::class, 'index'])
            ->name('admin.reports.index');

        Route::get('/reports/{type}.csv', [ReportController::class, 'export'])
            ->name('admin.reports.export');

        // ---- Announcements ----

        Route::get('/announcements', [AnnouncementController::class, 'index'])
            ->name('admin.announcements.index');

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
