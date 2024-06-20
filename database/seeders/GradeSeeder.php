<?php

namespace Database\Seeders;

use App\Models\Grade;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grades = [
            [
                'activity_id' => 1,
                'student_id' => 1,
                'grade_date' => Carbon::now()->subDays(5),
                'grade_value' => 4.5,
                'grade_weight' => 0.5,
                'description' => 'Test 1',
            ],
            [
                'activity_id' => 1,
                'student_id' => 1,
                'grade_date' => Carbon::now()->subDays(3),
                'grade_value' => 5.0,
                'grade_weight' => 0.3,
                'description' => 'Kartkówka',
            ],
            [
                'activity_id' => 2,
                'student_id' => 1,
                'grade_date' => Carbon::now()->subDays(7),
                'grade_value' => 3.75,
                'grade_weight' => 0.4,
                'description' => 'Quiz',
            ],
        ];

        // Wypełnienie bazy danych danymi z tablicy $grades
        foreach ($grades as $grade) {
            Grade::create($grade);
        }
    }
}
