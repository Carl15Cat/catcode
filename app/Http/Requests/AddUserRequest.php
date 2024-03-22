<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstname' => 'required|regex:/^[А-ЯЁ][а-яё]+$/u',
            'lastname' => 'required|regex:/^[А-ЯЁ][а-яё]+$/u',
            'patronymic' => 'nullable|regex:/^[А-ЯЁ][а-яё]+$/u',
            'login' => 'required',
            'password' => 'required|min:6',
            'password-repeat' => 'required|same:password',
            'role_id' => 'required',
        ];
    }

    public function messages() {
        return [
            'firstname.required' => 'Поле "Имя" обязательно',
            'lastname.required' => 'Поле "Фамилия" обязательно',
            'password.required' => 'Поле "Пароль" обязательно',
            'password-repeat.required' => 'Поле "Повтор пароля" обязательно',

            'firstname.regex' => 'Имя должно содержать только кириллицу и начинаться с заглавной буквы',
            'lastname.regex' => 'Фамилия должна содержать только кириллицу и начинаться с заглавной буквы',
            'patronymic.regex' => 'Отчество должно содержать только кириллицу и начинаться с заглавной буквы',

            'password.min' => 'Пароль должен содержать минимум 6 символов',
            'same' => 'Пароли не совпадают',  
            
            'role_id' => 'Укажите роль пользователя',
        ];
    }
}
