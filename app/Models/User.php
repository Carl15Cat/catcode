<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use App\Builders\UserBuilder;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Кастомный билдер
     */
    public function newEloquentBuilder($query) : UserBuilder {
        return new UserBuilder($query);
    }

    /**
     * Возвращает роль пользователя
     */
    public function role() {
        return $this->belongsTo(Role::class)->first();
    }

    /**
     * Возвращает список групп, в которых числится пользователь
     */
    public function groups() {
        return $this->belongsToMany(Group::class);
    }

    /**
     * Возвращает список решений данного пользователя
     */
    public function solutions() {
        return $this->hasMany(Solution::class);
    }
}
