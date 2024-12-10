<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            'phone_number' => 'sometimes|required|string|max:15',
            'status' => 'sometimes|nullable|in:pending,in preparation,out for delivery,delivered,cancelled',
            'location_id' => 'sometimes|nullable|exists:locations,id',
        ];
    }

    public function messages(): array
    {
        return [
            'phone_number.required' => 'Номер телефона обязателен.',
            'phone_number.string' => 'Номер телефона должен быть строкой.',
            'phone_number.max' => 'Номер телефона не может превышать 15 символов.',
            'status.in' => 'Статус должен быть одним из следующих: pending, in preparation, out for delivery, delivered, cancelled.',
            'location_id.exists' => 'Локация с данным ID не существует.',
        ];
    }
}
