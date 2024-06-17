<?php

namespace App\Http\Controllers;

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
    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'first_name' => 'required|string|max:50|regex:/^[a-zA-Z]+$/',
            'last_name' => 'required|string|max:50|regex:/^[a-zA-Z]+$/',
            'phone' => 'string|max:20',
            'comments' => 'nullable|string',
        ]);

        $teacher->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone' => $request->input('phone'),
            'comments' => $request->input('comments'),
        ]);

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
