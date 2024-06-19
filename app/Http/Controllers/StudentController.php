<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\Student;
use App\Models\StudentClass;
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
}
