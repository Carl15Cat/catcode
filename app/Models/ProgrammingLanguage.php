<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgrammingLanguage extends Model
{
    use HasFactory;

    /**
     * Возвращает список всех языков, отсортированных по названию
     */
    public static function getAll() {
        return self::orderBy('name')->get();
    }
}
