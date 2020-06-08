<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class PromotionalDiscountRequest extends FormRequest
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
        $format = 'Y-m-d\TH:i:s.u\Z';

        return [
            'title' => ['required', 'max:255'],
            'text' => ['required', 'max:2500'],
            'validFrom' => ['required', 'date', 'date_format:' . $format],
            'validTill' => ['required', 'date', 'date_format:' . $format],
            'price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'dishes' => ['nullable', 'array']
        ];
    }
}
