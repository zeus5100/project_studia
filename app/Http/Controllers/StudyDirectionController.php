<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudyDirectionRequest;
use App\Models\StudyDirection;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudyDirectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('page')) {
            $directions = StudyDirection::select('id', 'name', 'created_at', 'updated_at')
                ->paginate(10);
        } else {
            $directions = StudyDirection::select('id', 'name', 'created_at', 'updated_at')
                ->get();
        }

        return response()->json([
            'directions' => $directions,
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
    public function edit(StudyDirection $direction)
    {
        return Inertia::render('Auth/StudyDirection/Edit', [
            'direction' => $direction,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudyDirectionRequest $request, StudyDirection $direction)
    {
        $direction->update($request->validated());

        return redirect()->route('admin.manage', ['table' => 'directions']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudyDirection $direction)
    {
        try {
            $direction->delete();

            return response()->json(['message' => 'Przedmiot został pomyślnie usunięty'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Wystąpił błąd podczas usuwania przedmiotu'], 500);
        }
    }
}
