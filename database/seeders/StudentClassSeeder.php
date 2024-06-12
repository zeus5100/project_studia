<?php

namespace Database\Seeders;

use App\Models\StudentClass;
use App\Models\StudyDirection;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class StudentClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StudentClass::updateOrCreate(
            ['name' => '1 Ti'],
            [
                'academic_year' => '2023/2024',
                'study_direction_id' => StudyDirection::find(1)->id,
                'teacher_id' => Teacher::find(1)->id,
                'student_count' => 0,
            ]
        );

        StudentClass::updateOrCreate(
            ['name' => '2 Ti'],
            [
                'academic_year' => '2024/2025',
                'study_direction_id' => StudyDirection::find(1)->id,
                'teacher_id' => Teacher::find(1)->id,
                'student_count' => 0,
            ]
        );
    }
}
