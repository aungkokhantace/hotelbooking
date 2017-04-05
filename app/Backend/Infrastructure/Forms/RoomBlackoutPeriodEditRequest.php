<?php

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;

class RoomBlackoutPeriodEditRequest extends Request
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
            'hotel_id'      => 'required',
            'room_id'       => 'required',
            'from_date'     => 'required',
            'to_date'       => 'required',
        ];
    }

    public function messages()
    {
        return [
            'hotel_id.required'      => 'Hotel is required!',
            'room_id.required'       => 'Room is required!',
            'from_date.required'     => 'Unavailable From Date is required!',
            'to_date.required'       => 'Unavailable To Date is required!',
        ];
    }
}