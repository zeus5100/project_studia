<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'login' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $adminRole = Role::where('name', 'admin')->first();

        // Przypisz rolę administratora do użytkownika
        if ($adminRole) {
            $admin->roles()->attach($adminRole);
        }

        $teacher = User::create([
            'login' => 'testTeacher',
            'email' => 'teacher@example.com',
            'password' => Hash::make('password'),
        ]);
        $teacher->teacher()->create([
            'first_name' => 'testTeacher',
            'last_name' => 'testTeacher',
            'phone' => 'testTeacher',
        ]);
        $teacherRole = Role::where('name', 'teacher')->first();

        // Przypisz rolę administratora do użytkownika
        if ($teacherRole) {
            $teacher->roles()->attach($teacherRole);
        }
    }
}
