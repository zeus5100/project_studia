<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonRequest;
use App\Models\Lesson;

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
}
