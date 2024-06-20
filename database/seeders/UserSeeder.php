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
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'login' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        $adminRole = Role::where('name', 'admin')->first();

        // Przypisz rolę administratora do użytkownika
        if ($adminRole) {
            $admin->roles()->attach($adminRole);
        }

        $teacher = User::updateOrCreate(
            ['email' => 'teacher@example.com'],
            [
                'login' => 'teacher',
                'password' => Hash::make('password'),
            ]
        );
        $teacher->teacher()->updateOrCreate([
            'first_name' => 'Marcel',
            'last_name' => 'Kaliński',
            'phone' => '+48 400 400 200',
        ]);
        $teacherRole = Role::where('name', 'teacher')->first();

        // Przypisz rolę administratora do użytkownika
        if ($teacherRole) {
            $teacher->roles()->attach($teacherRole);
        }
    }
}
