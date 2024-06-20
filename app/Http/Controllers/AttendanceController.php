<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceRequest;
use App\Models\Attendance;
use App\Models\Lesson;
use Illuminate\Support\Facades\Redirect;

class AttendanceController extends Controller
{
    public function store(AttendanceRequest $request)
    {
        $data = $request->validated();

        $attendanceRecords = [];
        foreach ($data['attendance'] as $studentId => $attendanceStatusId) {
            $attendanceRecords[] = [
                'lesson_id' => $data['lesson_id'],
                'student_id' => $studentId,
                'attendance_status_id' => $attendanceStatusId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        Attendance::insert($attendanceRecords);
    }

    public function update(AttendanceRequest $request, Lesson $lesson)
    {
        $data = $request->validated();
        foreach ($data['attendance'] as $studentId => $attendanceStatusId) {
            $lesson->attendance()->updateOrCreate(
                ['lesson_id' => $lesson->id, 'student_id' => $studentId],
                ['attendance_status_id' => $attendanceStatusId]
            );
        }
        $activity = $lesson->activity;

        return Redirect::route('lessons', ['activity' => $activity]);
    }
}
