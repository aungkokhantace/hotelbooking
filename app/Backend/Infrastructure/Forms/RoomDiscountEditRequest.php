<?php

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;

class RoomDiscountEditRequest extends Request
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

              'name'              => 'required|unique:room_discount,name,'.$this->get('id').',id,hotel_id,'.Input::get('hotel_id').',h_room_category_id,'.Input::get('h_room_category_id').',from_date,'.Carbon::parse(Input::get('from_date'))->format('Y-m-d').',to_date,'.Carbon::parse(Input::get('to_date'))->format('Y-m-d').',deleted_at,NULL',
            'hotel_id'          => 'required',
            // 'h_room_type_id'    => 'required',
            'h_room_category_id'=> 'required',
            'type'              => 'required',
            'discount_amount'   => 'required|numeric',
            'from_date'         => 'required',
            'to_date'           => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'              => 'Name is required!',
            'name.unique'                => 'Room discount already exists!',
            'hotel_id.required'          => 'Hotel is required!',
            // 'h_room_type_id.required'    => 'Room Type is required!',
            'h_room_category_id.required'=> 'Room Category is required!',
            'type.required'              => 'Type is required!',
            'discount_amount.required'   => 'Discount Amount is required!',
            'discount_amount.numeric'   => 'Discount Amount must be a number!',
            'from_date.required'         => 'From Date is required!',
            'to_date.required'           => 'To Date is required!',
        ];
    }
}
