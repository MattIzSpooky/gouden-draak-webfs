<?php

namespace App\Http\Requests\API;

use App\Rules\UniqueMenuItem;
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
                new UniqueMenuItem($this->input('addition')),
            ],
            'addition' => [
                'nullable',
                'regex:/^[A-Z0-9]{1,3}$/',
                'exists:menu_additions,character'
            ]
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
            'menuNumber.unique' => 'Given menuNumber and addition are not unique',
        ];
    }
}
