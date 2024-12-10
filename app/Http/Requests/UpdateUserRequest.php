<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $this->route('user'),
            'password' => 'sometimes|required|string|min:8',
            'phone_number' => 'sometimes|required|string|unique:users,phone_number,' . $this->route('user'),
            'is_admin' => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Имя обязательно для заполнения.',
            'name.string' => 'Имя должно быть строкой.',
            'name.max' => 'Имя не должно превышать 255 символов.',
            'email.required' => 'Email обязателен для заполнения.',
            'email.email' => 'Укажите корректный адрес электронной почты.',
            'email.unique' => 'Этот email уже зарегистрирован.',
            'password.required' => 'Пароль обязателен для заполнения.',
            'password.string' => 'Пароль должен быть строкой.',
            'password.min' => 'Пароль должен содержать не менее 8 символов.',
            'phone_number.required' => 'Номер телефона обязателен для заполнения.',
            'phone_number.string' => 'Номер телефона должен быть строкой.',
            'phone_number.unique' => 'Этот номер телефона уже используется.',
            'is_admin.boolean' => 'Поле "является администратором" должно быть истинным или ложным.',
        ];
    }
}
