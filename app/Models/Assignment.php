<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function group() {
        return $this->belongsTo(Group::class)->first();
    }

    public function task() {
        return $this->belongsTo(Task::class)->first();
    }

    public function programmingLanguage() {
        return $this->task()->programmingLanguage();
    }

    public function deadline() {
        return date_create_from_format('Y-m-d H:i:s', $this->deadline)->format('H:i d.m.Y');
    }

    public function solutions() {
        return $this->hasMany(Solution::class);
    }

    public function getSolution($userId) {
        return $this->solutions()->where('user_id', $userId)->first();
    }

    public function isExpired() {
        return $this->deadline < date('Y-m-d H:i:s');
    }
}
