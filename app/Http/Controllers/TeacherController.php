<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRequest;
use App\Models\Activity;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TeacherController extends Controller
{
    public function index()
    {
        return response()->json(Teacher::select('id', 'first_name', 'last_name', 'phone')
            ->paginate(10));
    }

    public function select()
    {
        return response()->json(Teacher::select('id', 'first_name', 'last_name', 'phone')
            ->get());
    }

    public function edit(Teacher $teacher)
    {
        return Inertia::render('Auth/Teacher/Edit', [
            'teacher' => $teacher,
        ]);
    }

    public function update(TeacherRequest $request, Teacher $teacher)
    {
        $teacher->update($request->validated());

        return redirect()->route('admin.manage', ['table' => 'teachers'])
            ->with('notification', 'nauczyciela');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return response()->json([
            'message' => 'Nauczyciel został pomyślnie usunięty',
        ]);
    }

    public function activities()
    {
        $user = Auth::user();

        $teacher = $user->teacher->load('activities.subject', 'activities.room', 'activities.studentClass');

        return Inertia::render('Auth/Teacher/Activities', [
            'teacher' => $teacher,
        ]);
    }

    public function lesson(Activity $activity)
    {
        $teacherId = Auth::user()->teacher->id;
        $activities = Activity::select('id', 'student_class_id', 'subject_id')
            ->where('teacher_id', $teacherId)
            ->with('subject:id,name')
            ->with('studentClass:id,name')
            ->groupBy('student_class_id', 'subject_id')
            ->get();

        return Inertia::render('Auth/Teacher/Lesson', [
            'activity' => $activity,
            'activities' => $activities,
        ]);
    }

    public function students()
    {
        $teacher = Auth::user()->teacher;

        if (! $teacher->studentClasses()->first()) {
            $students = null;
            $studentClass = null;
        } else {
            $students = $teacher->studentClasses()->first()->students;
            $studentClass = $teacher->studentClasses()->with('direction')->first();
        }

        return Inertia::render('Auth/Teacher/Students', [
            'students' => $students,
            'studentClass' => $studentClass,
        ]);
    }
}
