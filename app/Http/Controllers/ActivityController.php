<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivityRequest;
use App\Models\Activity;
use App\Models\Lesson;
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

    public function getLessons(Activity $activity)
    {
        $lessons = Lesson::whereHas('activity', function ($query) use ($activity) {
            $query->where('subject_id', $activity->subject_id)
                ->where('student_class_id', $activity->student_class_id);
        })
            ->select('id', 'lesson_topic', 'lesson_datetime', 'comments')
            ->orderByDesc('lesson_datetime') // Sortowanie malejąco po lesson_datetime
            ->paginate(10);

        return $lessons;
    }

    public function lessons(Activity $activity)
    {
        $lessons = $this->getLessons($activity);

        return Inertia::render('Auth/Teacher/Lessons', [
            'activity' => $activity->load('subject', 'room', 'studentClass'),
            'lessons' => $lessons,
        ]);
    }

    public function grades(Activity $activity)
    {
        $students = $activity->grades()
            ->with(['student']) // Dodajemy relację 'student'
            ->get()
            ->groupBy('student_id')
            ->map(function ($grades) {
                return [
                    'student' => $grades->first()->student,
                    'grades' => $grades->map(function ($grade) {
                        return [
                            'id' => $grade->id,
                            'grade_value' => $grade->grade_value,
                            'description' => $grade->description, // Pobieramy 'description' z obiektu $grade
                        ];
                    }),
                ];
            });

        return Inertia::render('Auth/Teacher/Grades', [
            'activity' => $activity->subject,
            'students' => $students,
        ]);
    }
}
