<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentClassRequest;
use App\Models\StudentClass;
use App\Models\StudyDirection;
use App\Models\Teacher;
use Inertia\Inertia;

class StudentClassController extends Controller
{
    public function index()
    {
        return response()->json(StudentClass::select('id', 'name', 'academic_year', 'student_count', 'study_direction_id', 'teacher_id')->paginate(10));
    }

    public function select()
    {
        return response()->json(StudentClass::select('id', 'name', 'academic_year', 'student_count', 'study_direction_id', 'teacher_id')
            ->get());
    }

    public function edit(StudentClass $studentClass)
    {
        return Inertia::render('Auth/Classes/Edit', [
            'student_class' => $studentClass->load('direction', 'teacher'),
            'directions' => StudyDirection::all(),
            'teachers' => Teacher::all(),
        ]);
    }

    public function update(StudentClassRequest $request, StudentClass $studentClass)
    {
        $studentClass->update($request->validated());

        return redirect()->route('admin.manage', ['table' => 'classes'])->with('notification', 'klasę');
    }

    public function destroy(StudentClass $studentClass)
    {
        $studentClass->delete();

        return response()->json([
            'message' => 'Nauczyciel został pomyślnie usunięty',
        ]);
    }
}
