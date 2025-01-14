<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMenuItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**[
     * 'name' => 'required|string|length:2,255',
     * 'description' => 'required|text',
     * 'price_category_id_FK' => 'required|exists:price_category,id',
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|max:1000',
            'price_category_id' => 'sometimes|exists:price_categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.sometimes' => 'Поле имени является необязательным, но если оно указано, оно должно быть строкой и длиной от 2 до 255 символов.',
            'name.string' => 'Имя должно быть строкой.',
            'name.max' => 'Имя должно содержать до 255 символов.',

            'description.required' => 'Описание не обязательно для заполнения, но если оно указано, оно должно быть строкой и длиной от 10 до 1000 символов.',
            'description.string' => 'Описание должно быть строкой.',
            'description.max' => 'Описание не должно превышать 1000 символов.',

            'price_category_id.sometimes' => 'Идентификатор категории цены является необязательным, но если он указан, он должен существовать в базе данных.',
            'price_category_id.exists' => 'Выбранная категория цены не существует.',
        ];
    }
}
