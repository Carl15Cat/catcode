<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddAutotestRequest extends FormRequest
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
            'name' => 'nullable',
            'input' => 'required',
            'expected_output' => 'required',
            'is_hidden' => 'boolean|nullable',
        ];
    }

    public function messages() {
        return [
            'required' => 'Требуется указать вводные данные и ожидаемый результат',
        ];
    }
}
