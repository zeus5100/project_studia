<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\StudentClassController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('main');

Route::middleware(['auth', 'verified', 'role:Admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return Inertia::render('AdministratorPanel');
    })->name('admin.dashboard');

    Route::get('/classes', [StudentClassController::class, 'index']);
    Route::get('/rooms', [RoomController::class, 'index']);
    Route::get('/subjects', [SubjectController::class, 'index']);
    Route::get('/teachers', [TeacherController::class, 'index']);

    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('event', [EventController::class, 'create'])
        ->name('event');
    Route::post('event', [EventController::class, 'store']);

    Route::get('activity', [ActivityController::class, 'create'])
        ->name('activity');
    Route::post('activity', [ActivityController::class, 'store']);
});
Route::middleware(['auth', 'verified', 'role:Teacher'])->group(function () {
    Route::get('/teacher/dashboard', function () {
        return Inertia::render('TeacherPanel');
    })->name('teacher.dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
