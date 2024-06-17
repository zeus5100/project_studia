<?php

namespace App\Http\Controllers;

use App\Models\StudentClass;

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
}
