<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PointsController;
use App\Http\Controllers\PolygonsController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\SettingsController;

// Landing page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Halaman login redirect ke /home setelah login
Route::get('/home', [HomeController::class, 'index'])
    ->middleware('auth')
    ->name('home');
Route::get('/help', function () {
    return view('help');
})->name('help');

Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
Route::post('/settings/theme-toggle', [SettingsController::class, 'toggleTheme'])->name('settings.toggleTheme');

// Dashboard setelah verifikasi
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Peta & tabel
    Route::get('/map', [PointsController::class, 'index'])->name('map');
    Route::get('/table', [TableController::class, 'index'])->name('table');

    // Notifikasi
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])
    ->middleware(['auth'])->name('notifications');


    // Pengaturan dan bantuan
    Route::view('/settings', 'settings')->name('settings');
    Route::view('/help', 'help')->name('help');

    // Profil user
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// CRUD Resource
Route::resource('points', PointsController::class);
Route::resource('polygons', PolygonsController::class);

// Route tambahan landing page
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');

// API GeoJSON
Route::get('/api/points', [PointsController::class, 'api'])->name('api.points');
Route::get('/api/polygons', [PolygonsController::class, 'api'])->name('api.polygons');

// Auth routes (login, register, password, dsb)
require __DIR__.'/auth.php';
