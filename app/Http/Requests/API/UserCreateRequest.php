<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            'badge' => ['required', 'digits_between:2,5', 'unique:users'],
            'password' => ['required', 'max:255'],
            'userRoleId' => ['required', 'integer', 'exists:user_roles,id']
        ];
    }
}
