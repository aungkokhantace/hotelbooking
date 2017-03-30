<?php

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;

class HotelRestaurantEntryRequest extends Request
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
            'hotel_id'                  => 'required',
            'hotel_restaurant_category' => 'required',
            'name'                      => 'required',
            'opening_hours'             => 'required',
            'opening_days'              => 'required',
            'capacity'                  => 'required',
            'area'                      => 'required',
            'floor'                     => 'required',
        ];
    }

    public function messages()
    {
        return [
            'hotel_id.required'                     => 'Hotel is required!',
            'hotel_restaurant_category.required'    => 'Hotel Restaurant Category required!',
            'name.required'                         => 'Restaurant Name is required!',
            'opening_hours.required'                => 'Opening Hours is required!',
            'opening_days.required'                 => 'Opening Days is required!',
            'capacity.required'                     => 'Capacity is required!',
            'area.required'                         => 'Area is required!',
            'floor.required'                        => 'Floor is required!',
        ];
    }
}
