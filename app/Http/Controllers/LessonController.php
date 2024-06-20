<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonRequest;
use App\Models\AttendanceStatus;
use App\Models\Lesson;
use Inertia\Inertia;

class LessonController extends Controller
{
    public function store(LessonRequest $request)
    {
        Lesson::create($request->validated());
    }

    public function destroy(Lesson $lesson)
    {
        $lesson->delete();

        return response()->json(['message' => 'Lekcja została pomyślnie usunięta']);
    }

    public function attendence(Lesson $lesson)
    {
        $activity = $lesson->activity;
        $studentClass = $activity->studentClass;
        $students = $studentClass->students;

        $attendanceExists = $lesson->attendance()->exists();
        $attendanceStatuses = AttendanceStatus::select('id', 'name')->get();

        if ($attendanceExists) {

            return Inertia::render('Auth/Teacher/EditAttendance', [
                'lesson' => $lesson,
                'activity' => $lesson->activity,
                'students' => $students,
                'attendanceStatuses' => $attendanceStatuses,
                'existingAttendance' => $lesson->attendance,
            ]);
        } else {
            return Inertia::render('Auth/Teacher/Attendence', [
                'activity' => $lesson->activity,
                'lesson' => $lesson,
                'students' => $students,
                'attendenceStatuses' => $attendanceStatuses,
            ]);
        }
    }
}
