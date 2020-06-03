<?php

namespace App\Http\Requests\API;

use Illuminate\Validation\Rule;
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
            'dishTypeId' => ['required', 'exists:dish_types,id'],
            'menuNumber' => [
                'required',
                'numeric',
                'unique:menu_items,menu_number,NULL,addition' . $this->input('addition'),
            ],
            'addition' => ['nullable', 'exists:menu_additions,character']
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'menuNumber.unique' => 'Given menuNumber and addition are not unique'
        ];
    }
}
