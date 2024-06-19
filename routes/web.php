<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\StudentClassController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudyDirectionController;
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

    Route::inertia('/admin/dashboard', 'AdministratorPanel')->name('admin.dashboard');

    Route::get('/admin/manage/{table}', function ($table) {
        return Inertia::render('ManagePanel', [
            'table' => $table,
            'notification' => session('notification'),
        ]);
    })->name('admin.manage');

    Route::get('/rooms', [RoomController::class, 'select'])->name('rooms.select');

    Route::name('classes.')->prefix('classes')->group(function () {
        Route::get('/', [StudentClassController::class, 'index'])->name('index');
        Route::get('/select', [StudentClassController::class, 'select'])->name('select');
        Route::get('/{studentClass}/edit', [StudentClassController::class, 'edit'])->name('edit');
        Route::put('/{studentClass}', [StudentClassController::class, 'update'])->name('update');
    });

    Route::name('subjects.')->prefix('subjects')->group(function () {
        Route::get('/', [SubjectController::class, 'index'])->name('index');
        Route::get('/select', [SubjectController::class, 'select'])->name('select');
        Route::delete('/{subject}', [SubjectController::class, 'destroy'])->name('destroy');
        Route::get('/{subject}/edit', [SubjectController::class, 'edit'])->name('edit');
        Route::put('/{subject}', [SubjectController::class, 'update'])->name('update');
    });

    Route::name('teachers.')->prefix('teachers')->group(function () {
        Route::get('/', [TeacherController::class, 'index'])->name('index');
        Route::get('/select', [TeacherController::class, 'select'])->name('select');
        Route::delete('/{teacher}', [TeacherController::class, 'destroy'])->name('destroy');
        Route::get('/{teacher}/edit', [TeacherController::class, 'edit'])->name('edit');
        Route::put('/{teacher}', [TeacherController::class, 'update'])->name('update');
    });

    Route::name('students.')->prefix('students')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('index');
        Route::get('/select', [StudentController::class, 'select'])->name('select');
        Route::delete('/{student}', [StudentController::class, 'destroy'])->name('destroy');
        Route::get('/{student}/edit', [StudentController::class, 'edit'])->name('edit');
        Route::put('/{student}', [StudentController::class, 'update'])->name('update');
    });

    Route::name('directions.')->prefix('directions')->group(function () {
        Route::get('/', [StudyDirectionController::class, 'index'])->name('index');
        Route::get('/select', [StudyDirectionController::class, 'select'])->name('select');
        Route::delete('/{direction}', [StudyDirectionController::class, 'destroy'])->name('destroy');
        Route::get('/{direction}/edit', [StudyDirectionController::class, 'edit'])->name('edit');
        Route::put('/{direction}', [StudyDirectionController::class, 'update'])->name('update');
    });

    Route::name('events.')->prefix('events')->group(function () {
        Route::get('/create', [EventController::class, 'create'])->name('create');
        Route::post('/', [EventController::class, 'store'])->name('store');
    });

    Route::name('activities.')->prefix('activities')->group(function () {
        Route::get('/create', [ActivityController::class, 'create'])->name('create');
        Route::post('/', [ActivityController::class, 'store'])->name('store');
    });

    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
});

Route::middleware(['auth', 'verified', 'role:Teacher'])->group(function () {
    Route::inertia('/teacher/dashboard', 'TeacherPanel')->name('teacher.dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
