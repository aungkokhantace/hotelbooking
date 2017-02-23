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
            'name'          => "required|string|unique:countries,name,".$this->get('id'),
        ];
    }
    public function messages()
    {
        return [
            'name.required'         => 'Country Name is required!',
            'name.unique'           => 'Country Name is already occupied!',
            'name.string'           => 'Country Name must be a string!',
        ];
    }
}
