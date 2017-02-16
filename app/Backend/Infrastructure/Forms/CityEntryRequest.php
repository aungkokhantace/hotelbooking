<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/20/2016
 * Time: 3:56 PM
 */

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;

class CityEntryRequest extends Request
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'country_id'         => 'required',
            'city_name'          => 'required|string|unique:cities'
        ];
    }
    public function messages()
    {
        return [
            'country_id'         => 'Country is required',
            'city_name.required' => 'City Name is required!'

        ];
    }
}
