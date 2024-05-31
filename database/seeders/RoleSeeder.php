<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Statements\RoleName;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::updateOrCreate([
            'name' => RoleName::TEACHER,
        ], [
            'description' => 'Rola nauczyciela',
        ]);

        Role::updateOrCreate([
            'name' => RoleName::STUDENT,
        ], [
            'description' => 'Rola ucznia',
        ]);

        Role::updateOrCreate([
            'name' => RoleName::ADMIN,
        ], [
            'description' => 'Rola administratora',
        ]);
    }
}
