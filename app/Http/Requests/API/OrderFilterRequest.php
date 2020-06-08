<?php

namespace App\Http\Requests\API;

use Carbon\Carbon;
use Carbon\Traits\Date;
use Illuminate\Foundation\Http\FormRequest;

class OrderFilterRequest extends FormRequest
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
            'from' => ['required', 'date', 'date_format:' . $format],
            'to' => ['required', 'date', 'date_format:' . $format]
        ];
    }
}
