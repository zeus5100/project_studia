<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\StudentClass;
use App\Models\StudyDirection;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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

        $student = User::updateOrCreate(
            ['email' => 'student@example.com'],
            [
                'login' => 'student1',
                'password' => Hash::make('password'),
            ]
        );
        $student->student()->updateOrCreate([
            'first_name' => 'Dominik',
            'last_name' => 'Kaliński',
            'student_class_id' => 1,
        ]);
        $teacherRole = Role::where('name', 'student')->first();
        if ($teacherRole) {
            $student->roles()->attach($teacherRole);
        }

        $student = User::updateOrCreate(
            ['email' => 'student2@example.com'],
            [
                'login' => 'student12',
                'password' => Hash::make('password'),
            ]
        );
        $student->student()->updateOrCreate([
            'first_name' => 'Kacper',
            'last_name' => 'Malinowski',
            'student_class_id' => 1,
        ]);
        $teacherRole = Role::where('name', 'student')->first();
        if ($teacherRole) {
            $student->roles()->attach($teacherRole);
        }
    }
}
