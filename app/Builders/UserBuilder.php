<?php

namespace App\Builders;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserBuilder extends Builder
{
    /**
     * Возвращает список пользователей, у которых
     * любое из полей (имя, фамилия, отчество, логин)
     * содержит переданную подстроку
     */
    public function search($query) : self {
        if(is_null($query) && $query != ''){
            // Без поиска, вывод всех пользователей
            return $this;
        } else {
            // Поиск по всем полям
            return $this->where( function($q) use ($query) {
                $q->where('firstname', 'LIKE', "%$query%")
                ->orWhere('lastname', 'LIKE', "%$query%")
                ->orWhere('patronymic', 'LIKE', "%$query%")
                ->orWhere('login', 'LIKE', "%$query%");
            });
        }
    }
}