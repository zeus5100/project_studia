<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudyDirectionRequest;
use App\Models\StudyDirection;
use Inertia\Inertia;

class StudyDirectionController extends Controller
{
    public function index()
    {
        return response()->json(StudyDirection::select('id', 'name', 'created_at', 'updated_at')
            ->paginate(10));
    }

    public function select()
    {
        return response()->json(StudyDirection::select('id', 'name')->get());
    }

    public function edit(StudyDirection $direction)
    {
        return Inertia::render('Auth/StudyDirection/Edit', [
            'direction' => $direction,
        ]);
    }

    public function update(StudyDirectionRequest $request, StudyDirection $direction)
    {
        $direction->update($request->validated());

        return redirect()->route('admin.manage', ['table' => 'directions']);
    }

    public function destroy(StudyDirection $direction)
    {
        try {
            $direction->delete();

            return response()->json(['message' => 'Przedmiot został pomyślnie usunięty']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Wystąpił błąd podczas usuwania przedmiotu'], 500);
        }
    }
}
