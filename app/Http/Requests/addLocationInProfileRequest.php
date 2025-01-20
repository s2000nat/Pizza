<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class addLocationInProfileRequest extends FormRequest
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
            'city' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'house_number' => 'required|string|max:50',
            'floor' => 'nullable|integer|min:0',
            'apartment' => 'nullable|integer|min:0',
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
            'user_id.exists' => 'Пользователь должен существовать.',
        ];
    }
}
