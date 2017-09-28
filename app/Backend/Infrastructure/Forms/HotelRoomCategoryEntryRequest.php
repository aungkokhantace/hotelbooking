<?php

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;

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
            'name'                  => 'required',
            'capacity'              => 'required',
            'booking_cutoff_day'    => 'required',
            'bed_type'              => 'required',
            'price'                 => 'required',
            'square_metre'          => 'required',
        ];
    }

    public function messages()
    {
        return [
            // 'hotel_id.required'             => 'Hotel is required!',
            'h_room_type_id.required'       => 'Room Type is required!',
            'name.required'                 => 'Name is required!',
            'capacity.required'             => 'Capacity is required!',
            'booking_cutoff_day.required'   => 'Booking CutOff Day is required!',
            'bed_type.required'             => 'Bed Type is required!',
            'price.required'                => 'Price is required!',
            'square_metre.required'         => 'S.Q.M is required!',
        ];
    }
}
