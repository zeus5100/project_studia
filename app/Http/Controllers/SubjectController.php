<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubjectRequest;
use App\Models\Subject;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubjectController extends Controller
{
    public function index()
    {

        return response()->json(Subject::select('id', 'name', 'created_at', 'updated_at')->paginate(10));
    }

    public function select()
    {
        return response()->json(Subject::select('id', 'name')->get());
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

    public function edit(Subject $subject)
    {
        return Inertia::render('Auth/Subject/Edit', [
            'subject' => $subject,
        ]);
    }

    public function update(SubjectRequest $request, Subject $subject)
    {
        $subject->update($request->validated());

        return redirect()->route('admin.manage', ['table' => 'subjects']);
    }

    public function destroy(Subject $subject)
    {
        try {
            $subject->delete();

            return response()->json(['message' => 'Przedmiot został pomyślnie usunięty']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Wystąpił błąd podczas usuwania przedmiotu'], 500);
        }
    }
}
