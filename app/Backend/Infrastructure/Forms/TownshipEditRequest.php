<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/20/2016
 * Time: 3:56 PM
 */

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;

class TownshipEditRequest extends Request
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'city_id'                => 'required',
            'township_name'          => 'required|string|unique:countries'
        ];
    }
    public function messages()
    {
        return [
            'city_id'                => 'City is required',
            'township_name.required' => 'Township Name is required!'

        ];
    }
}
