<?php

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Input;

class HotelRoomCategoryEntryRequest extends Request
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
            // 'hotel_id'              => 'required',
            'h_room_type_id'        => 'required',
            'name'                  => 'required|unique:h_room_category,name,NULL,id,hotel_id,'.Input::get('hotel_id').',deleted_at,NULL',
            'capacity'              => 'required|numeric',
            'booking_cutoff_day'    => 'required|numeric',
            'bed_types'             => 'required',
            'price'                 => 'required|numeric',
            'square_metre'          => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            // 'hotel_id.required'             => 'Hotel is required!',
            'h_room_type_id.required'       => 'Room Type is required!',
            'name.required'                 => 'Name is required!',
            'name.unique'                   => 'Room Category already exists!',
            'capacity.required'             => 'Capacity is required!',
            'capacity.numeric'              => 'Capacity must be numeric!',
            'booking_cutoff_day.required'   => 'Booking CutOff Day is required!',
            'booking_cutoff_day.numeric'    => 'Booking Cutoff Day must be numeric!',
            'bed_types.required'            => 'Bed Types are required!',
            'price.required'                => 'Price is required!',
            'price.numeric'                 => 'Price must be numeric!',
            'square_metre.required'         => 'S.Q.M is required!',
            'square_metre.numeric'          => 'S.Q.M must be numeric!',
        ];
    }
}
