<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRequest;
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

    public function activities(Teacher $teacher)
    {
        $user = Auth::user();

        if ($user->teacher) {
            $teacher = $user->teacher;
            $teacher->load('activities.subject');

            return Inertia::render('Auth/Teacher/Activities', [
                'teacher' => $teacher,
            ]);
        }
    }
}
