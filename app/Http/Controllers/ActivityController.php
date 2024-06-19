<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivityRequest;
use App\Models\Activity;
use App\Models\Room;
use App\Models\StudentClass;
use App\Models\Subject;
use App\Models\Teacher;
use Inertia\Inertia;

class ActivityController extends Controller
{
    public function index()
    {
        return response()->json(Activity::select('id', 'teacher_id', 'student_class_id', 'subject_id', 'room_id', 'start_time', 'end_time', 'day_of_week')
            ->paginate(10));
    }

    public function create()
    {
        return Inertia::render('Auth/Activity/Activity', [
            'classes' => StudentClass::all(),
            'subjects' => Subject::all(),
            'rooms' => Room::all(),
            'teachers' => Teacher::all(),
        ]);
    }

    public function store(ActivityRequest $request)
    {
        Activity::create($request->validated());
    }

    public function edit(Activity $activity)
    {
        return Inertia::render('Auth/Activity/Edit', [
            'activity' => $activity,
            'classes' => StudentClass::all(),
            'subjects' => Subject::all(),
            'rooms' => Room::all(),
            'teachers' => Teacher::all(),
        ]);
    }

    public function update(ActivityRequest $request, Activity $activity)
    {
        $activity->update($request->validated());

        return redirect()->route('admin.manage', ['table' => 'activities'])
            ->with('notification', 'zajęcie');
    }
}
