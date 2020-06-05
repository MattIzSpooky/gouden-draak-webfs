<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuItemUpdateRequest extends FormRequest
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
                'exists:menu_items,menu_number'
            ],
            'addition' => [
                'nullable',
                'regex:/^[A-Z]{1}$/',
                'exists:menu_additions,character'
            ]
        ];
    }
}
