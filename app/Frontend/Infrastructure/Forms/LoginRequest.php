<?php

namespace App\Frontend\Infrastructure\Forms;

use App\Http\Requests\Request;

class LoginRequest extends Request
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
            'user_name' => 'required',
            'password'=> 'required',
        ];
    }
    public function messages()
    {
        return [
            'user_name.required' => 'Please type email.',
            'password.required' => 'Please type password.',
        ];
    }
}
