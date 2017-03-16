<?php

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;

class RoomEntryRequest extends Request
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
            'hotel_id'          => 'required',
            'h_room_type_id'    => 'required',
            'h_room_category_id'=> 'required',
            'room_view_id'      => 'required',
            'name'              => 'required',
            'status'            => 'required',
        ];
    }
    public function messages()
    {
        return [
            'hotel_id.required'             => 'Hotel is required!',
            'h_room_type_id.required'       => 'Room Type is required!',
            'h_room_category_id.required'   => 'Room Category is required!',
            'room_view_id.required'         => 'Room View is required!',
            'name.required'                 => 'Name is required!',
            'status.required'               => 'Status is required!'
        ];
    }
}
