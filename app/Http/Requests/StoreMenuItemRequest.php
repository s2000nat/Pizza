<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMenuItemRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'sometimes|string|max:1000|min:10',
            'price_category_id' => 'required|exists:price_categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле имени обязательно для заполнения.',
            'name.string' => 'Имя должно быть строкой.',
            'name.max' => 'Имя должно содержать до 255 символов.',

            'description.required' => 'Описание обязательно для заполнения.',
            'description.string' => 'Описание должно быть строкой.',
            'description.max' => 'Описание не должно превышать 1000 символов.',
            'description.min' => 'Описание должно содержать не менее 10 символов.',

            'price_category_id.required' => 'Идентификатор категории цены обязателен для заполнения.',
            'price_category_id.exists' => 'Выбранная категория цены не существует.',
        ];
    }
}
