<?php

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;

class RoomCategoryAmenityEditRequest extends Request
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
            'h_room_category_id'=> 'required',
            'amenity'           => 'required',
            'value'             => 'required',
        ];
    }
    public function messages()
    {
        return [
            'h_room_category_id.required'   => 'Room Category is required!',
            'amenity.required'              => 'Amenity is required!',
            'value.required'                => 'Value is required!',
        ];
    }
}
