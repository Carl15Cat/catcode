<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    /**
     * Возвращает переменные данного задания
     */
    public function variables() {
        return json_decode($this->variables);
    }

    /**
     * Возвращает автотесты данного задания
     */
    public function autotests() {
        return $this->hasMany(Autotest::class);
    }

    /**
     * Возвращает список групп, которым дали это задание
     */
    public function groups() {
        return $this->belongsToMany(Group::class)->withPivot('deadline');
    }
}
