<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSizeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'slug' => 'required|string|unique:sizes,slug|max:255',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'slug.required' => 'Поле slug обязательно для заполнения.',
            'slug.string' => 'Поле slug должно быть строкой.',
            'slug.unique' => 'Этот slug уже существует.',
            'slug.max' => 'Поле slug не должно превышать 255 символов.',
        ];
    }
}
