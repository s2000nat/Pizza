<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategorySizePriceRequest extends FormRequest
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
            'price_category_id' => 'sometimes|exists:price_categories,id',
            'sizes_id' => 'sometimes|exists:sizes,id',
            'price' => 'sometimes|integer'
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'price_category_id.exists' => 'Поле price_category_id_FK должно ссылаться на существующую запись в таблице price_categories.',
            'sizes_id.exists' => 'Поле sizes_id_FK должно ссылаться на существующую запись в таблице sizes.',
            'price.integer' => 'Поле price должно быть целым числом.',
        ];
    }
}
