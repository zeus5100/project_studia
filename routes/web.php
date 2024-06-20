<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceStatusController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\LessonController;
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
})->name('home');

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

    Route::name('attendanceStatuses.')->prefix('attendanceStatuses')->group(function () {
        Route::get('/', [AttendanceStatusController::class, 'index'])->name('index');
        Route::get('/select', [AttendanceStatusController::class, 'select'])->name('select');
        Route::delete('/{attendanceStatus}', [AttendanceStatusController::class, 'destroy'])->name('destroy');
        Route::get('/{attendanceStatus}/edit', [AttendanceStatusController::class, 'edit'])->name('edit');
        Route::put('/{attendanceStatus}', [AttendanceStatusController::class, 'update'])->name('update');
    });

    Route::name('activities.')->prefix('activities')->group(function () {
        Route::get('/', [ActivityController::class, 'index'])->name('index');
        Route::get('/select', [ActivityController::class, 'select'])->name('select');
        Route::delete('/{activity}', [ActivityController::class, 'destroy'])->name('destroy');
        Route::get('/{activity}/edit', [ActivityController::class, 'edit'])->name('edit');
        Route::put('/{activity}', [ActivityController::class, 'update'])->name('update');
        Route::get('/create', [ActivityController::class, 'create'])->name('create');
        Route::post('/', [ActivityController::class, 'store'])->name('store');
    });

    Route::name('rooms.')->prefix('rooms')->group(function () {
        Route::get('/', [RoomController::class, 'index'])->name('index');
        Route::get('/select', [RoomController::class, 'select'])->name('select');
        Route::delete('/{room}', [RoomController::class, 'destroy'])->name('destroy');
        Route::get('/{room}/edit', [RoomController::class, 'edit'])->name('edit');
        Route::put('/{room}', [RoomController::class, 'update'])->name('update');
    });

    Route::name('events.')->prefix('events')->group(function () {
        Route::get('/create', [EventController::class, 'create'])->name('create');
        Route::post('/', [EventController::class, 'store'])->name('store');
        Route::get('/', [EventController::class, 'index'])->name('index');
        Route::get('/select', [EventController::class, 'select'])->name('select');
        Route::delete('/{event}', [EventController::class, 'destroy'])->name('destroy');
        Route::get('/{event}/edit', [EventController::class, 'edit'])->name('edit');
        Route::put('/{event}', [EventController::class, 'update'])->name('update');
    });

    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
});

Route::middleware(['auth', 'verified', 'role:Teacher'])->group(function () {
    Route::inertia('/teacher/dashboard', 'TeacherPanel')->name('teacher.dashboard');
    Route::get('/lessons/{activity}', [ActivityController::class, 'lessons'])->name('lessons');
    Route::get('/getLessons/{activity}', [ActivityController::class, 'getLessons'])->name('getLessons');
    Route::get('activities/{activity}/students', [ActivityController::class, 'grades'])->name('activities.students.grades');

    Route::get('/activities', [TeacherController::class, 'activities'])->name('activities');
    Route::get('/lesson/{activity}', [TeacherController::class, 'lesson'])->name('lesson');
    Route::post('/lesson', [LessonController::class, 'store'])->name('lesson.store');
    Route::delete('/lesson/{lesson}', [LessonController::class, 'destroy'])->name('lesson.destroy');

    Route::get('/students', [TeacherController::class, 'students'])->name('students');
    Route::get('/attendence/{lesson}', [LessonController::class, 'attendence'])->name('attendence');
    Route::post('/attendence', [AttendanceController::class, 'store'])->name('attendence.store');
    Route::put('/attendence/{lesson}', [AttendanceController::class, 'update'])->name('attendence.update');

    Route::get('/grades/create/{activity}', [GradeController::class, 'create'])->name('grade.create');
    Route::post('/grades/store}', [GradeController::class, 'store'])->name('grade.store');
});

Route::middleware(['auth', 'verified', 'role:Student'])->group(function () {
    Route::inertia('/student/dashboard', 'StudentPanel')->name('student.dashboard');
    Route::get('/activities', [StudentController::class, 'activities'])->name('activities');
    Route::get('/grades', [StudentController::class, 'grades'])->name('grades');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
