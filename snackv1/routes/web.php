<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\SnackController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::get('/', fn() => view('welcome'));

Route::middleware(['auth', 'verified'])->group(function () {

    // ── Dashboard (semua role, konten berbeda) ────────────────────────────────
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ── Statistik AJAX ────────────────────────────────────────────────────────
    Route::get('/snacks/statistik', [SnackController::class, 'statistik'])->name('snacks.statistik');

    // ── Export (semua role) ───────────────────────────────────────────────────
    Route::get('/snacks/export/pdf',   [SnackController::class, 'exportPdf'])->name('snacks.export.pdf');
    Route::get('/snacks/export/excel', [SnackController::class, 'exportExcel'])->name('snacks.export.excel');

    // ── CRUD Snack (semua role, pembatasan di controller) ────────────────────
    Route::resource('snacks', SnackController::class);

    // ── Riwayat (semua role, konten berbeda) ──────────────────────────────────
    Route::prefix('histories')->name('histories.')->group(function () {
        Route::get('/',             [HistoryController::class, 'index'])  ->name('index');
        Route::get('/{history}',    [HistoryController::class, 'show'])   ->name('show');
        Route::delete('/{history}', [HistoryController::class, 'destroy'])->name('destroy');
    });

    // ── Khusus Admin ──────────────────────────────────────────────────────────
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class)->except(['create', 'store']);
        Route::patch('/users/{user}/role',   [UserController::class, 'updateRole'])->name('users.role');
        Route::patch('/users/{user}/toggle', [UserController::class, 'toggle'])    ->name('users.toggle');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


