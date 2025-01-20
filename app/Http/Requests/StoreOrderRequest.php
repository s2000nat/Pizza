<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'phone_number' => 'required|string|max:15',
            'location_id' => 'required|exists:locations,id',
            'status' => 'nullable|in:pending,in preparation,out for delivery,delivered,cancelled',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'ID пользователя обязателен.',
            'user_id.exists' => 'Пользователь с данным ID не существует.',
            'phone_number.required' => 'Номер телефона обязателен.',
            'phone_number.string' => 'Номер телефона должен быть строкой.',
            'phone_number.max' => 'Номер телефона не может превышать 15 символов.',
            'location_id.required' => 'ID локации обязателен.',
            'location_id.exists' => 'Локация с данным ID не существует.',
            'status.in' => 'Статус должен быть одним из следующих: pending, in preparation, out for delivery, delivered, cancelled.',
        ];
    }
}
