<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRequest;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TeacherController extends Controller
{
    public function index()
    {

        return response()->json([
            'teachers' => Teacher::select('id', 'first_name', 'last_name', 'phone')
                ->paginate(10),
        ]);
    }

    public function select()
    {
        return response()->json([
            'teachers' => Teacher::select('id', 'first_name', 'last_name', 'phone')
                ->get(),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
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

        return redirect()->route('admin.manage', ['table' => 'teachers']);
    }

    public function destroy(Teacher $teacher)
    {
        try {
            $teacher->delete();

            return response()->json([
                'message' => 'Nauczyciel został pomyślnie usunięty',
            ]);
        } catch (\Exception $e) {
            dd($e);

            return response()->json([
                'message' => 'Wystąpił błąd podczas usuwania nauczyciela',
            ], 500);
        }
    }
}
