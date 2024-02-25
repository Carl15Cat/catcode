<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Role;
use App\Models\Group;
use App\Models\Task;
use App\Models\Variable_type;

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

        // По 10 случайных студентов в группы
        $students = User::where('role_id', 3)->get();

        Group::all()->each(function ($group) use ($students){
            $group->belongsToMany(User::class)->attach(
                $students->random(30)->pluck('id')->toArray()
            ); 
        });

        Task::insert([
            'user_id' => 1,
            'name' => 'Тестовое задание',
            'description' => fake()->sentence(50),
            'variables' => json_encode(['a' => 'string', 'b' => 'int']),
        ]);

        Variable_type::insert([
            'name' => 'string'
        ]);
        Variable_type::insert([
            'name' => 'integer'
        ]);
    }
}
