<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePriceCategoryRequest extends FormRequest
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
            'slug' => 'required|string|unique:price_categories,slug|max:255',
        ];
    }

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
