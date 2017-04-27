<?php

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;

class HotelFeatureEntryRequest extends Request
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
            'feature_id'    => 'required',
            'qty'           => 'required',
            'capacity'      => 'required',
            'area'          => 'required',
            'open_hour'     => 'required',
            'close_hour'    => 'required',
        ];
    }

    public function messages()
    {
        return [
            'hotel_id.required'     => 'Hotel is required!',
            'feature_id.required'   => 'Feature is required!',
            'qty'                   => 'Quantity is required',
            'capacity'              => 'Capacity is required',
            'area'                  => 'Area is required',
            'open_hour'             => 'Open hour is required',
            'close_hour'            => 'Close hour is required',
        ];
    }
}
