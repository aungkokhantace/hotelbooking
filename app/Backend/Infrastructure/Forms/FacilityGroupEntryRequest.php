<?php

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;

class FacilityGroupEntryRequest extends Request
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
            'name'   => 'required',

        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Facility Group Name is required!',


        ];
    }
}
