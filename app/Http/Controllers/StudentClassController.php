<?php

namespace App\Http\Controllers;

use App\Models\StudentClass;
use Illuminate\Http\Request;

class StudentClassController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('page')) {
            $classes = StudentClass::select('id', 'name', 'academic_year', 'student_count', 'study_direction_id', 'teacher_id')->paginate(10);
        } else {
            $classes = StudentClass::select('id', 'name', 'academic_year', 'student_count', 'study_direction_id', 'teacher_id')
                ->get();
        }

        return response()->json([
            'classes' => $classes,
        ]);
    }
}
