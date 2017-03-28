<?php

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;

class HotelNearbyAirportEntryRequest extends Request
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
            'name'          => 'required',
            'distance'      => 'required',
        ];
    }

    public function messages()
    {
        return [
            'hotel_id.required'      => 'Hotel is required!',
            'name.required'          => 'Name is required!',
            'distance.required'      => 'Distance is required!',
        ];
    }
}
