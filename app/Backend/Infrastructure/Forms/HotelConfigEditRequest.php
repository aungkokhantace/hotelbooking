<?php

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;

class HotelConfigEditRequest extends Request
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
            'hotel_id'              => 'required',
            'first_cancellation_day' => 'required',
            'second_cancellation_day'=> 'required',
            'breakfast_fees'        => 'required|numeric',
            'extrabed_fees'         => 'required|numeric',
            'tax'                   => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'hotel_id.required'             => 'Hotel is required!',
            'first_cancellation_day.required'    => 'First Cancellation Day is required!',
            'second_cancellation_day.required'    => 'Second Cancellation Day is required!',
            'breakfast_fees.required'       => 'Breakfast Fees is required!',
            'breakfast_fees.numeric'        => 'Breakfast Fees must be numeric!',
            'extrabed_fees.required'        => 'Extrabed Fees is required!',
            'extrabed_fees.numeric'         => 'Extrabed Fees must be numeric!',
            'tax.required'                  => 'Tax is required!',
            'tax.numeric'                   => 'Tax must be numeric!',
        ];
    }
}
