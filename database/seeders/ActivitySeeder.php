<?php

namespace Database\Seeders;

use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activities = [
            [
                'student_class_id' => 1,
                'subject_id' => 1,
                'room_id' => 1,
                'teacher_id' => 1,
                'start_time' => Carbon::createFromFormat('H:i:s', '08:00:00'),
                'end_time' => Carbon::createFromFormat('H:i:s', '08:45:00'),
                'day_of_week' => 1,
                'comments' => 'Regular class session',
            ],
            [
                'student_class_id' => 1,
                'subject_id' => 2,
                'room_id' => 2,
                'teacher_id' => 1,
                'start_time' => Carbon::createFromFormat('H:i:s', '08:50:00'),
                'end_time' => Carbon::createFromFormat('H:i:s', '09:35:00'),
                'day_of_week' => 2,
                'comments' => 'Special topic discussion',
            ],
            [
                'student_class_id' => 1,
                'subject_id' => 3,
                'room_id' => 3,
                'teacher_id' => 1,
                'start_time' => Carbon::createFromFormat('H:i:s', '09:45:00'),
                'end_time' => Carbon::createFromFormat('H:i:s', '10:30:00'),
                'day_of_week' => 5,
                'comments' => 'Review session for upcoming test',
            ],
        ];

        foreach ($activities as $activity) {
            Activity::create($activity);
        }
    }
}
