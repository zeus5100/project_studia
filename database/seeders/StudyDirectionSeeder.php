<?php

namespace Database\Seeders;

use App\Models\StudyDirection;
use Illuminate\Database\Seeder;

class StudyDirectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StudyDirection::updateOrCreate([
            'name' => 'Technik Informatyk',
        ]);
        StudyDirection::updateOrCreate([
            'name' => 'Technik Logistyk',
        ]);
        StudyDirection::updateOrCreate([
            'name' => 'Technik Programista',
        ]);
    }
}
