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
        $rules  = [
            'hotel_id'          => 'required',
            // 'h_room_type_id'    => 'required',
            'h_room_category_id'=> 'required',
            'room_view_id'      => 'required',
            'status'            => 'required',
        ];
        /*
        foreach($this->request->get('room_name') as $key => $val)
        {
            $rules['room_name['.$key.']'] = 'required';
        }*/

        return $rules;
    }
    public function messages()
    {
        $messages = [
            'hotel_id.required'             => 'Hotel is required!',
            // 'h_room_type_id.required'       => 'Room Type is required!',
            'h_room_category_id.required'   => 'Room Category is required!',
            'room_view_id.required'         => 'Room View is required!',
            'status.required'               => 'Status is required!'
        ];
        /*
        foreach($this->request->get('room_name') as $key => $val)
        {
            $messages['room_name['.$key.'].required'] = 'Room Name is required!';
        }*/

        return $messages;
    }
}
