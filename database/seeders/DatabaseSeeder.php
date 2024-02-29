<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Role;
use App\Models\Group;
use App\Models\Task;
use App\Models\Variable_type;
use App\Models\ProgrammingLanguage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Установка ролей        
        Role::insert([
            'name' => 'Администратор',
        ]);
        Role::insert([
            'name' => 'Преподаватель',
        ]);
        Role::insert([
            'name' => 'Студент',
        ]);

        // Установка доступных типов переменных
        Variable_type::insert([
            'name' => 'string'
        ]);
        Variable_type::insert([
            'name' => 'integer'
        ]);

        // Установка доступных языков программирования. id должен соответствовать id в judge0
        ProgrammingLanguage::insert([
            'id' => 68,
            'name' => 'PHP',
            'version' => '7.4.1',
        ]);
        ProgrammingLanguage::insert([
            'id' => 70,
            'name' => 'Python',
            'version' => '2.7.17',
        ]);
        ProgrammingLanguage::insert([
            'id' => 76,
            'name' => 'C++',
            'version' => 'Clang 7.0.1',
        ]);
        ProgrammingLanguage::insert([
            'id' => 51,
            'name' => 'C#',
            'version' => 'Mono 6.6.0.161',
        ]);
        ProgrammingLanguage::insert([
            'id' => 62,
            'name' => 'Java',
            'version' => 'OpenJDK 13.0.1',
        ]);
        ProgrammingLanguage::insert([
            'id' => 63,
            'name' => 'JavaScript',
            'version' => 'Node.js 12.14.0',
        ]);

        // Тестовые данные:

        // По одному пользователю каждой роли
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

        // Куча студентов для проверки пагинации
        User::factory()->count(1000)->create();

        // Несколько групп
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

        // Задание
        Task::insert([
            'user_id' => 1,
            'name' => 'Тестовое задание',
            'description' => fake()->sentence(50),
            'variables' => json_encode(['a' => 'string', 'b' => 'int']),
        ]);
    }
}
