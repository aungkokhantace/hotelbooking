<?php

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;

class EventEmailEditRequest extends Request
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
            'email'             => 'required|email',
            'description'      => 'required',
            'type'             => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required'         => 'Event Name is required!',
            'email.email'            => 'Email Address is wrong!',
            'description.required'  => 'Event Description is required!',
            'type.required'         => 'Type is required!',
        ];
    }
}
