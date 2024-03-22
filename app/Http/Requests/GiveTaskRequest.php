<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GiveTaskRequest extends FormRequest
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
            'deadline_date' => 'date|required',
            'deadline_time' => 'string|required',
        ];
    }

    public function messages() {
        return [
            'required' => 'Укажите дату и время срока сдачи',
            'date' => 'Укажите дату и время срока сдачи',
            'time' => 'Укажите дату и время срока сдачи',
        ];
    }
}
