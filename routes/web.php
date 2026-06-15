<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\MembershipRequestController;
use App\Http\Controllers\ClubMembershipManagementController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskCommentController;
use App\Http\Controllers\BudgetTransactionController;
use App\Http\Controllers\ClubNotificationController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ClubMemberController;
use App\Http\Controllers\ClubDashboardController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('clubs', ClubController::class)->only([
    'index', 'create', 'store', 'show'
]);
    Route::get('/clubs-browse', [MembershipRequestController::class, 'browse'])->name('clubs.browse');
    Route::post('/clubs/{club}/join', [MembershipRequestController::class, 'store'])->name('clubs.join');
    
    Route::get('/clubs/{club}/membership-requests', [ClubMembershipManagementController::class, 'requests'])
    ->name('clubs.membership-requests');

Route::patch('/clubs/{club}/memberships/{membership}/approve', [ClubMembershipManagementController::class, 'approve'])
    ->name('clubs.memberships.approve');

Route::patch('/clubs/{club}/memberships/{membership}/refuse', [ClubMembershipManagementController::class, 'refuse'])
    ->name('clubs.memberships.refuse');

    Route::get('/clubs/{club}/events', [EventController::class, 'index'])->name('clubs.events.index');
Route::get('/clubs/{club}/events/create', [EventController::class, 'create'])->name('clubs.events.create');
Route::post('/clubs/{club}/events', [EventController::class, 'store'])->name('clubs.events.store');
Route::get('/clubs/{club}/events/{event}', [EventController::class, 'show'])->name('clubs.events.show');

Route::get('/clubs/{club}/tasks', [TaskController::class, 'index'])->name('clubs.tasks.index');
Route::get('/clubs/{club}/tasks/create', [TaskController::class, 'create'])->name('clubs.tasks.create');
Route::post('/clubs/{club}/tasks', [TaskController::class, 'store'])->name('clubs.tasks.store');
Route::get('/clubs/{club}/tasks/{task}', [TaskController::class, 'show'])->name('clubs.tasks.show');

Route::post('/clubs/{club}/tasks/{task}/comments', [TaskCommentController::class, 'store'])
    ->name('clubs.tasks.comments.store');

 Route::get('/clubs/{club}/budget', [BudgetTransactionController::class, 'index'])->name('clubs.budget.index');
Route::get('/clubs/{club}/budget/create', [BudgetTransactionController::class, 'create'])->name('clubs.budget.create');
Route::post('/clubs/{club}/budget', [BudgetTransactionController::class, 'store'])->name('clubs.budget.store');   

Route::get('/notifications', [ClubNotificationController::class, 'index'])->name('notifications.index');

Route::get('/clubs/{club}/notifications/create', [ClubNotificationController::class, 'create'])
    ->name('clubs.notifications.create');

Route::get('/clubs/{club}/notifications/sent', [ClubNotificationController::class, 'sent'])
    ->name('clubs.notifications.sent');

Route::get('/clubs/{club}/notifications/sent/{batchId}', [ClubNotificationController::class, 'readers'])
    ->name('clubs.notifications.readers');

Route::post('/clubs/{club}/notifications', [ClubNotificationController::class, 'store'])
    ->name('clubs.notifications.store');

Route::patch('/notifications/{notification}/read', [ClubNotificationController::class, 'markAsRead'])
    ->name('notifications.read');

Route::get('/clubs/{club}/events/{event}/attendance-qr', [AttendanceController::class, 'qr'])
    ->name('clubs.events.attendance.qr');

Route::get('/clubs/{club}/events/{event}/attendances', [AttendanceController::class, 'index'])
    ->name('clubs.events.attendances.index');

Route::get('/attendance/{qrCode}', [AttendanceController::class, 'scan'])
    ->name('attendance.scan');

Route::post('/attendance/{qrCode}', [AttendanceController::class, 'store'])
    ->name('attendance.store');

Route::get('/clubs/{club}/events/{event}/attendances/pdf', [AttendanceController::class, 'exportPdf'])
    ->name('clubs.events.attendances.pdf');

    Route::get('/clubs/{club}/members', [ClubMemberController::class, 'index'])
    ->name('clubs.members.index');

Route::patch('/clubs/{club}/members/{membership}', [ClubMemberController::class, 'update'])
    ->name('clubs.members.update');

Route::delete('/clubs/{club}/members/{membership}', [ClubMemberController::class, 'destroy'])
    ->name('clubs.members.destroy');

    Route::get('/clubs/{club}/dashboard', [ClubDashboardController::class, 'show'])
    ->name('clubs.dashboard');
  
  Route::get('/clubs/{club}/events/{event}/edit', [EventController::class, 'edit'])
    ->name('clubs.events.edit');

Route::patch('/clubs/{club}/events/{event}', [EventController::class, 'update'])
    ->name('clubs.events.update');

Route::delete('/clubs/{club}/events/{event}', [EventController::class, 'destroy'])
    ->name('clubs.events.destroy');

  Route::get('/clubs/{club}/tasks/{task}/edit', [TaskController::class, 'edit'])
    ->name('clubs.tasks.edit');

Route::patch('/clubs/{club}/tasks/{task}', [TaskController::class, 'update'])
    ->name('clubs.tasks.update');

Route::delete('/clubs/{club}/tasks/{task}', [TaskController::class, 'destroy'])
    ->name('clubs.tasks.destroy');
    
 Route::get('/clubs/{club}/budget/{budgetTransaction}/edit', [BudgetTransactionController::class, 'edit'])
    ->name('clubs.budget.edit');

Route::patch('/clubs/{club}/budget/{budgetTransaction}', [BudgetTransactionController::class, 'update'])
    ->name('clubs.budget.update');

Route::delete('/clubs/{club}/budget/{budgetTransaction}', [BudgetTransactionController::class, 'destroy'])
    ->name('clubs.budget.destroy'); 
    
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

Route::get('/clubs/{club}/edit', [ClubController::class, 'edit'])->name('clubs.edit');
Route::patch('/clubs/{club}', [ClubController::class, 'update'])->name('clubs.update');
});

