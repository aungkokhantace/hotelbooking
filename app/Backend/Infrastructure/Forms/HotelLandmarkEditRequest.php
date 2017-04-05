<?php

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;

class HotelLandmarkEditRequest extends Request
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
            'landmark'      => 'required',
        ];
    }

    public function messages()
    {
        return [
            'hotel_id.required'      => 'Hotel is required!',
            'landmark.required'      => 'Landmark is required!',
        ];
    }
}