<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {

        $relations = [
            'studentClasses' => 'Klasy',
            'activities' => 'Zajęcia',
        ];

        $relatedTables = [];
        foreach ($relations as $relation => $relationName) {
            if ($teacher->$relation()->exists()) {
                $relatedTables[] = $relationName;
            }
        }

        if (! empty($relatedTables)) {
            $tables = implode(', ', $relatedTables);

            return response()->json([
                'status' => 'error',
                'message' => "Nie można usunąć nauczyciela, ponieważ jest powiązany z tabelą: $tables.",
            ], 200);
        }

        try {
            $teacher->delete();

            return response()->json([
                'status' => 'succes',
                'message' => 'Nauczyciel został pomyślnie usunięty',
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => 'Wystąpił błąd podczas usuwania nauczyciela',
            ], 200);
        }
    }
}
