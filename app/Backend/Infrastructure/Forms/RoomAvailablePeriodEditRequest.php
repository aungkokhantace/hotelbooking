<?php

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;

class RoomAvailablePeriodEditRequest extends Request
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
            'room_id'       => 'required|unique:r_available_period,room_id,'.$this->get('id').',id,hotel_id,'.Input::get('hotel_id').',room_id,'.Input::get('room_id').',from_date,'.Carbon::parse(Input::get('from_date'))->format('Y-m-d').',to_date,'.Carbon::parse(Input::get('to_date'))->format('Y-m-d').',deleted_at,NULL',
            'from_date'     => 'required',
            'to_date'       => 'required',
        ];
    }

    public function messages()
    {
        return [
            'hotel_id.required'      => 'Hotel is required!',
            'room_id.required'       => 'Room is required!',
            'room_id.unique'         => 'Room already exists!',
            'from_date.required'     => 'Available From Date is required!',
            'to_date.required'       => 'Available To Date is required!',
        ];
    }
}
