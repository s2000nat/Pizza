<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePriceCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'slug' => 'required|string|unique:price_categories,slug|max:255',
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
