<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $subjects = [
            'Matematyka',
            'Polski',
            'Historia',
            'Biologia',
            'Chemia',
            'Fizyka',
            'Informatyka',
            'Język angielski',
            'Język niemiecki',
            'Język francuski',
        ];

        foreach ($subjects as $subject) {
            Subject::create(['name' => $subject]);
        }
    }
}
