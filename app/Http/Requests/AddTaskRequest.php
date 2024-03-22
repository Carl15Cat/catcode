<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddTaskRequest extends FormRequest
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
            'name' => 'required',
            'description' => 'required',
            'language_id' => 'required',
        ];
    }

    public function messages() {
        return [
            'name.required' => 'Укажите название задания',
            'description.required' => 'Требуется описать задание',
            'language_id.required' => 'Выберите язык программирования',
        ];
    }
}
