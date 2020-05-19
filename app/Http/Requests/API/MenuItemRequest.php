<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class MenuItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:255'],
            'price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'description' => ['required', 'max:1500'],
            'dish_type_id' => ['required', 'exists:dish_types,id'],
            'menu_number' => ['required', 'numeric'],
            'addition' => ['nullable', 'exists:menu_additions,character']
        ];
    }
}
