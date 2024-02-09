<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Role;

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
    }
}
