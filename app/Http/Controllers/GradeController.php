<?php

namespace App\Http\Controllers;

use App\Http\Requests\GradeRequest;
use App\Models\Activity;
use App\Models\Grade;
use Inertia\Inertia;

class GradeController extends Controller
{
    public function create(Activity $activity)
    {
        $students = $activity->studentClass->students()
            ->get();

        return Inertia::render('Auth/Grade/Grade', [
            'activity' => $activity->load('subject'),
            'students' => $students,
        ]);
    }

    public function store(GradeRequest $request)
    {
        Grade::create($request->validated());
    }
}
