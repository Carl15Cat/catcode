<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Role;
use App\Models\Group;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::insert([
            'name' => 'Администратор',
        ]);
        Role::insert([
            'name' => 'Преподаватель',
        ]);
        Role::insert([
            'name' => 'Студент',
        ]);

        User::factory()->create([
            'login' => 'admin',
            'role_id' => 1,
        ]);
        User::factory()->create([
            'login' => 'teacher',
            'role_id' => 2,
        ]);
        User::factory()->create([
            'login' => 'student',
            'role_id' => 3,
        ]);

        // Для проверки пагинации
        User::factory()->count(1000)->create();

        Group::insert([
            'name' => 'ИС-449',
        ]);
        Group::insert([
            'name' => 'ИС-453',
        ]);
    }
}
