<?php

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;

class HotelFacilityEntryRequest extends Request
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
            'hotel_id'          => 'required',
            'facility_group'    => 'required',
            'facility'          => 'required',
        ];
    }

    public function messages()
    {
        return [
            'hotel_id.required'          => 'Hotel is required!',
            'facility_group.required'    => 'Facility Group is required!',
            'facility.required'          => 'Facility is required!',
        ];
    }
}
