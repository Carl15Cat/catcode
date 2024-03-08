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
            'highlight_name' => 'php',
            'default_code' => "<?php\n\techo \"Hello World!\";\n?>",
        ]);
        ProgrammingLanguage::insert([
            'id' => 70,
            'name' => 'Python',
            'version' => '2.7.17',
            'highlight_name' => 'python',
            'default_code' => "print(\"Hello World!\")",
        ]);
        ProgrammingLanguage::insert([
            'id' => 76,
            'name' => 'C++',
            'version' => 'Clang 7.0.1',
            'highlight_name' => 'cpp',
            'default_code' => "#include <iostream>\n\nint main() {\n\tstd::cout << \"Hello World!\";\n}",
        ]);
        ProgrammingLanguage::insert([
            'id' => 51,
            'name' => 'C#',
            'version' => 'Mono 6.6.0.161',
            'highlight_name' => 'cs',
            'default_code' => "using System;\n\nnamespace Catcode {\n\tclass Program {\n\t\tstatic void Main(string[] args) {\n\t\t\tConsole.WriteLine(\"Hello World!\");\n\t\t}\n\t}\n}",
        ]);
        ProgrammingLanguage::insert([
            'id' => 62,
            'name' => 'Java',
            'version' => 'OpenJDK 13.0.1',
            'highlight_name' => 'java',
            'default_code' => "class Main {\n\tpublic static void main(String[] args) {\n\t\tSystem.out.println(\"Hello World!\");\n\t}\n}",
        ]);
        ProgrammingLanguage::insert([
            'id' => 63,
            'name' => 'JavaScript',
            'version' => 'Node.js 12.14.0',
            'highlight_name' => 'javascript',
            'default_code' => "console.log(\"Hello World!\")",
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
            'programming_language_id' => 68,
        ]);
    }
}
