<?php

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;

class RoomCategoryFacilityEditRequest extends Request
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
            'facility'          => 'required',
            'hotel_id'          => 'required',
            'h_room_type_id'    => 'required',
            'h_room_category_id'=> 'required',
            'value'             => 'required',
        ];
    }
    public function messages()
    {
        return [
            'facility.required'             => 'Facility is required!',
            'hotel_id.required'             => 'Hotel is required!',
            'h_room_type_id.required'       => 'Room Type is required!',
            'h_room_category_id.required'   => 'Room Category is required!',
            'value.required'                => 'Value is required!',
        ];
    }
}
