<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/20/2016
 * Time: 3:56 PM
 */

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;

class CityEditRequest extends Request
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'country_id'         => 'required',
            'name'               => "required|string|unique:cities,name,".$this->get('id'),
//            'photo'              => 'required'
        ];
    }
    public function messages()
    {
        return [
            'country_id'         => 'Country is required',
            'name.required'      => 'City Name is required!',
            'name.unique'        => 'City Name is already occupied!',
//            'photo.required'     => 'Photo is required!'
        ];
    }
}
