<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'menu_item_id' => 'required|exists:menu_items,id',
            'category_size_price_id' => 'required|exists:category_size_prices,id',
        ];
    }

    public function messages(): array
    {
        return [
            'menu_item_id.required' => 'Поле menu_item_id_FK обязательно для заполнения.',
            'menu_item_id.exists' => 'Поле menu_item_id_FK должно ссылаться на существующую запись в таблице menu_items.',
            'category_size_prices_id.required' => 'Поле category_size_prices_id_FK обязательно для заполнения.',
            'category_size_prices_id.exists' => 'Поле category_size_prices_id_FK должно ссылаться на существующую запись в таблице category_size_prices.',
        ];
    }
}
