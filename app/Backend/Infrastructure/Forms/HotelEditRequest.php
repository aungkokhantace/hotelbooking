<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/20/2016
 * Time: 3:56 PM
 */

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;
use App\User;
use App\Setup\Hotel\Hotel;
class HotelEditRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $hotelObj = Hotel::find($this->get('id'));
        $user = User::find($hotelObj->admin_id);

        return [
            'name'                      => 'required',
            'name_jp'                   => 'required',
            'h_type_id'                 => 'required',
            'address'                   => 'required',
            'phone'                     => 'required',
//            'photo'                     => 'required',
            'star'                      => 'required',
//            'email'                     => "required|email|unique:hotels,email,".$this->get('id'),
            'country_id'                => 'required',
            'city_id'                   => 'required',
            'township_id'               => 'required',
            'number_of_floors'          => 'required',
            'check_in_time'             => 'required',
            'check_out_time'            => 'required',
            'breakfast_start_time'      => 'required',
            'breakfast_end_time'        => 'required',
            'latitude'                  => 'required|numeric',
            'longitude'                 => 'required|numeric',

            'display_name'      => 'required',
            'user_name'         => 'required|unique:core_users,user_name,'.$user->id,
            'user_email'             => 'required|email|unique:core_users,email,'.$user->id,

             //'hotel_id'              => 'required',
            'first_cancellation_day' => 'required',
            'second_cancellation_day'=> 'required',
            'breakfast_fees'        => 'required',
//            'extrabed_fees'         => 'required|numeric',
            'tax'                   => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'name.required'             => 'Name is required!',
            'name_jp.required'          => 'Name(JP) is required!',
            'h_type_id.required'        => 'Type is required!',
            'address.required'          => 'Address is required!',
            'phone.required'            => 'Phone is required!',
//            'photo.required'            => 'Photo is required!',
//            'star.required'             => 'Star is required!',
//            'email.required'            => 'Email is required!',
//            'email.email'               => 'Email is not valid!',
//            'email.unique'              => 'Email is already occupied!',
            'country_id.required'       => 'Country is required!',
            'city_id.required'          => 'City is required!',
            'township_id.required'      => 'Township is required!',
            'number_of_floors.required' => 'Number of floors is required!',
            'check_in_time.required'    => 'Check-in time is required!',
            'check_out_time.required'   => 'Check-out time is required!',
            'breakfast_start_time.required'=> 'Breakfast start time is required!',
            'breakfast_end_time.required'  => 'Breakfast end time is required!',
            'latitude.required'       => 'Latitude is required!',
            'latitude.numeric'        => 'Latitude must be numeric!',
            'longitude.required'      => 'Longitude is required!',
            'longitude.numeric'       => 'Longitude must be numeric!',


            "user_name.required"        => "User Login Name is required",
            "user_name.unique"        => "User Login Name is already occupied",
            "display_name.required"     => "User Display Name is required",
            "user_email.required"            => "Email is required",
            "user_email.email"            => "Email is not vaild",
            "user_email.unique"            => "Email is already occupied",

            'hotel_id.required'             => 'Hotel is required!',
            'first_cancellation_day.required'    => 'First Cancellation Day is required!',
            'second_cancellation_day.required'    => 'Second Cancellation Day is required!',
            'breakfast_fees.required'       => 'Breakfast Fees is required!',
            'breakfast_fees.numeric'        => 'Breakfast Fees must be numeric!',
//            'extrabed_fees.required'        => 'Extrabed Fees is required!',
//            'extrabed_fees.numeric'         => 'Extrabed Fees must be numeric!',
            'tax.required'                  => 'Tax is required!',
            'tax.numeric'                   => 'Tax must be numeric!',
        ];
    }
}
