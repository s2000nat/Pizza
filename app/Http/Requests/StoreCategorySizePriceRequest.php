<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategorySizePriceRequest extends FormRequest
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
            'price_category_id' => 'required|exists:price_categories,id',
            'size_id' => 'required|exists:sizes,id',
            'price' => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'price_category_id.required' => 'Поле price_category_id_FK обязательно для заполнения.',
            'price_category_id.exists' => 'Поле price_category_id_FK должно ссылаться на существующую запись в таблице price_categories.',
            'size_id.required' => 'Поле sizes_id_FK обязательно для заполнения.',
            'size_id.exists' => 'Поле sizes_id_FK должно ссылаться на существующую запись в таблице sizes.',
            'price.required' => 'Поле price обязательно для заполнения.',
            'price.integer' => 'Поле price должно быть целым числом.',
        ];
    }
}
