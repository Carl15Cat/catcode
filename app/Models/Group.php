<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    /**
     * Возвращает список пользователей, 
     */
    public function users() {
        return $this->belongsToMany(User::class)->orderBy('lastname')->orderBy('firstname');
    }

    /**
     * Возвращает задания, данные группе
     */
    public function tasks(){
        return $this->hasMany(Assignment::class)->orderBy('deadline');
    }
}
