<?php

namespace App\Http\Controllers;

use App\Models\StudentClass;

class StudentClassController extends Controller
{
    public function index()
    {
        return response()->json([
            'classes' => StudentClass::all(),
        ]);
    }
}
