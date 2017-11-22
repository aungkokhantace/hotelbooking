<?php

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;

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
            'name'              => 'required',
            'hotel_id'          => 'required',
            // 'h_room_type_id'    => 'required',
            'h_room_category_id'=> 'required',
            'type'              => 'required',
            'discount_amount'   => 'required',
            'from_date'         => 'required',
            'to_date'           => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'              => 'Name is required!',
            'hotel_id.required'          => 'Hotel is required!',
            // 'h_room_type_id.required'    => 'Room Type is required!',
            'h_room_category_id.required'=> 'Room Category is required!',
            'type.required'              => 'Type is required!',
            'discount_amount.required'   => 'Discount Amount is required!',
            'from_date.required'         => 'From Date is required!',
            'to_date.required'           => 'To Date is required!',
        ];
    }
}
