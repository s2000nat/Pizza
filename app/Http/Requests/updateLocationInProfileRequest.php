<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class updateLocationInProfileRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<string, string>|string>
     */
    public function rules(): array
    {
        return [
            'city' => 'sometimes|required|string|max:255',
            'street' => 'sometimes|required|string|max:255',
            'house_number' => 'sometimes|required|string|max:50',
            'floor' => 'nullable|integer|min:0',
            'apartment' => 'nullable|integer|min:0',
            'deleted' => 'sometimes|boolean',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'city.required' => 'Город обязателен для заполнения.',
            'street.required' => 'Улица обязательна для заполнения.',
            'house_number.required' => 'Номер дома обязателен для заполнения.',
            'floor.integer' => 'Этаж должен быть целым числом.',
            'apartment.integer' => 'Квартира должна быть целым числом.',
        ];
    }
}
