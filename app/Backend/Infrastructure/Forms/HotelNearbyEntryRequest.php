<?php

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;

class HotelNearbyEntryRequest extends Request
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
            // 'name'              => 'required',
            'name'              => 'required|unique:nearby,name,NULL,id,deleted_at,NULL',
            'name_jp'           => 'required',
            'hotel_category'    => 'required',
            'description'       => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'               => 'Name is required!',
            'name.unique'                 => 'The name has already been taken!',
            'name_jp.required'            => 'Name(JP) is required!',
            'hotel_category.required'     => 'Hotel Category is required!',
            'description.required'        => 'Description is required!',
        ];
    }
}
