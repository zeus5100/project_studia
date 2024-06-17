<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRequest;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('page')) {
            $teachers = Teacher::select('id', 'first_name', 'last_name', 'phone')
                ->paginate(10);
        } else {
            $teachers = Teacher::select('id', 'first_name', 'last_name', 'phone')
                ->get();
        }

        return response()->json([
            'teachers' => $teachers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        return Inertia::render('Auth/Teacher/Edit', [
            'teacher' => $teacher,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TeacherRequest $request, Teacher $teacher)
    {

        $teacher->update($request->validated());

        return redirect()->route('admin.manage', ['table' => 'teachers']);
    }

    /**
     * Remove the specified resource from storage.
     */
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
