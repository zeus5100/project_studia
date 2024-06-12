<?php

namespace Database\Seeders;

use App\Models\AttendanceStatus;
use Illuminate\Database\Seeder;

class AttendanceStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $statuses = [
            'Obecny',
            'Nieobecny',
            'Spóźniony',
            'Usprawiedliwiony',
            'Nieusprawiedliwiony',
            'Zwolnienie lekarskie',
        ];

        foreach ($statuses as $status) {
            AttendanceStatus::create(['name' => $status]);
        }
    }
}
