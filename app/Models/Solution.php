<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solution extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function assignment() {
        return $this->belongsTo(Assignment::class)->first();
    }

    public function task() {
        return $this->assignment()->belongsTo(Task::class)->first();
    }

    public function executables() {
        return $this->hasMany(Executable::class);
    }
}
