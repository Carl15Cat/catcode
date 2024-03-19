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
     * Возвращает автотесты данного задания
     */
    public function autotests() {
        return $this->hasMany(Autotest::class);
    }

    /**
     * Возвращает список выданных заданий
     */
    public function assignments() {
        return $this->hasMany(Assignment::class);
    }

    /**
     * Возвращает ЯП, установленный для этого задания
     */
    public function programmingLanguage() {
        return $this->belongsTo(ProgrammingLanguage::class)->first();
    }
}
