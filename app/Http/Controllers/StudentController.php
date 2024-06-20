<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\Student;
use App\Models\StudentClass;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class StudentController extends Controller
{
    public function index()
    {
        return response()->json(Student::select('id', 'first_name', 'last_name', 'student_class_id')
            ->paginate(10));
    }

    public function select()
    {
        return response()->json(Student::select('id', 'first_name', 'last_name', 'student_class_id')
            ->get());
    }

    public function edit(Student $student)
    {
        return Inertia::render('Auth/Student/Edit', [
            'student' => $student->load('studentClass'),
            'classes' => StudentClass::all(),
        ]);
    }

    public function update(StudentRequest $request, Student $student)
    {
        $student->update($request->validated());

        return redirect()->route('admin.manage', ['table' => 'students'])
            ->with('notification', 'ucznia');
    }

    public function destroy(Student $teacher)
    {

        $teacher->delete();

        return response()->json([
            'message' => 'Uczeń został pomyślnie usunięty',
        ]);
    }

    public function activities()
    {
        $user = Auth::user();

        $student = $user->student;
        $studentClass = $student->studentClass->load('activities.subject', 'activities.room', 'activities.studentClass');

        return Inertia::render('Auth/Student/Activities', [
            'studentClass' => $studentClass,
        ]);
    }

    public function grades()
    {
        $user = Auth::user();

        $student = $user->student;
        $subjectsForClass = $student->studentClass->activities()->with('subject')->get()->pluck('subject')->unique();
        $grades = $student->grades->load('activity.subject');

        $gradesBySubject = $grades->groupBy(function ($grade) {
            return $grade->activity->subject->name;
        });

        return Inertia::render('Auth/Student/Grades', [
            'grades' => $gradesBySubject,
            'subjects' => $subjectsForClass,
        ]);
    }

    public function studentGrades(Student $student)
    {

        $subjectsForClass = $student->studentClass->activities()->with('subject')->get()->pluck('subject')->unique();
        $grades = $student->grades->load('activity.subject');

        $gradesBySubject = $grades->groupBy(function ($grade) {
            return $grade->activity->subject->name;
        });

        return Inertia::render('Auth/Teacher/StudentGrades', [
            'student' => $student,
            'grades' => $gradesBySubject,
            'subjects' => $subjectsForClass,
        ]);
    }
}
