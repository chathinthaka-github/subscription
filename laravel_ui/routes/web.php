<?php

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RenewalPlanController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceMessageController;
use App\Http\Controllers\ShortcodeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Root route - redirect based on authentication status
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Service Configuration
    Route::resource('shortcodes', ShortcodeController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('service-messages', ServiceMessageController::class);
    Route::get('/api/keywords/{shortcode}', [ServiceMessageController::class, 'getKeywords'])->name('api.keywords');

    // Schedules
    Route::resource('renewal-plans', RenewalPlanController::class);
    Route::get('/api/plan-keywords/{shortcode}', [RenewalPlanController::class, 'getKeywords'])->name('api.plan-keywords');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('/reports/search', [ReportController::class, 'search'])->name('reports.search');

    // Admin
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
        Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index');
        Route::get('permissions/{role}', [PermissionController::class, 'show'])->name('permissions.show');
        Route::post('permissions/{role}', [PermissionController::class, 'update'])->name('permissions.update');
    });
});
