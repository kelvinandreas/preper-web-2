<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserSettingsController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/sessions', [SessionController::class, 'index'])->name('sessions.index');
    Route::get('/sessions/request', [SessionController::class, 'request'])->name('sessions.request');
    Route::post('/sessions/request', [SessionController::class, 'storeRequest'])->name('sessions.storeRequest');
    Route::get('/sessions/available', [SessionController::class, 'available'])->name('sessions.available');
    Route::post('/sessions/{session}/accept', [SessionController::class, 'accept'])->name('sessions.accept');
    Route::post('/sessions/{session}/review', [SessionController::class, 'storeReview'])->name('sessions.storeReview');
});

Route::middleware('auth')->group(function () {
    Route::get('/user-settings', [UserSettingsController::class, 'index'])->name('user.settings');
    Route::post('/user-settings/update', [UserSettingsController::class, 'update'])->name('user.settings.update');
    Route::delete('/user-settings/delete/{id}', [UserSettingsController::class, 'delete'])->name('user.settings.delete');
});

require __DIR__ . '/auth.php';
