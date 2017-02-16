<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/20/2016
 * Time: 3:56 PM
 */

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;

class CountryEditRequest extends Request
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'countries_name'          => 'required|string|unique:countries'
        ];
    }
    public function messages()
    {
        return [
            'countries_name.required'         => 'Country Name is required!',

        ];
    }
}
