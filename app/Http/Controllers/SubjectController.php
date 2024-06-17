<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubjectRequest;
use App\Models\Subject;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('page')) {
            $subjects = Subject::paginate(10);
        } else {
            $subjects = Subject::all();
        }

        return response()->json([
            'subjects' => $subjects,
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
    public function edit(Subject $subject)
    {
        return Inertia::render('Auth/Subject/Edit', [
            'subject' => $subject,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubjectRequest $request, Subject $subject)
    {
        $subject->update($request->validated());

        return redirect()->route('admin.manage', ['table' => 'subjects']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        try {
            $subject->delete();

            return response()->json(['message' => 'Przedmiot został pomyślnie usunięty'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Wystąpił błąd podczas usuwania przedmiotu'], 500);
        }
    }
}
