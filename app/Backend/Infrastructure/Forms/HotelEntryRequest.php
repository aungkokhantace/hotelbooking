<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/20/2016
 * Time: 3:56 PM
 */

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;

class HotelEntryRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'                      => 'required',
            'h_type_id'                 => 'required',
            'address'                   => 'required',
            'phone'                     => 'required',
            'star'                      => 'required',
            'email'                     => 'required|email|unique:hotels',
            'country_id'                => 'required',
            'city_id'                   => 'required',
            'township_id'               => 'required',
            'number_of_floors'          => 'required',
            'hotel_class'               => 'required',
            'check_in_time'             => 'required',
            'check_out_time'            => 'required',
            'breakfast_start_time'      => 'required',
            'breakfast_end_time'        => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'             => 'Name is required!',
            'h_type_id.required'        => 'Type is required!',
            'address.required'          => 'Address is required!',
            'phone.required'            => 'Phone is required!',
            'star.required'             => 'Star is required!',
            'email.required'            => 'Email is required!',
            'email.email'               => 'Email is not valid!',
            'email.unique'              => 'Email is already occupied!',
            'country_id.required'       => 'Country is required!',
            'city_id.required'          => 'City is required!',
            'township_id.required'      => 'Township is required!',
            'number_of_floors.required' => 'Number of floors is required!',
            'hotel_class.required'      => 'Class is required!',
            'check_in_time.required'    => 'Check-in time is required!',
            'check_out_time.required'   => 'Check-out time is required!',
            'breakfast_start_time.required'=> 'Breakfast start time is required!',
            'breakfast_end_time.required'  => 'Breakfast end time is required!',
        ];
    }
}
