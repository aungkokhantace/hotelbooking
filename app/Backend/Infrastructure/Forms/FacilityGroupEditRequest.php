<?php

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;

class FacilityGroupEditRequest extends Request
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
            'name'          => 'required|unique:facility_group,name,'.$this->get('id').',id,deleted_at,NULL',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Facility Group Name is required!',
            'name.unique'   => 'The name has already been taken!',
        ];
    }
}
