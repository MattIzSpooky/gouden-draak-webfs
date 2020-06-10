<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'paidAt' => ['nullable', 'date'],
            'items' => ['filled'],
            'items.*.id' => ['required', 'integer', 'exists:menu_items,id'],
            'items.*.amount' => ['required', 'integer']
        ];
    }
}
