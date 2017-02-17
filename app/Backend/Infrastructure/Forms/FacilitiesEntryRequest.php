<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/20/2016
 * Time: 3:56 PM
 */

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;

class FacilitiesEntryRequest extends Request
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'facilities_name'   => 'required',
            'facilities_icon'   => 'required | mimes:jpeg,jpg,png',
        ];
    }
    public function messages()
    {
        return [
            'facilities_name.required' => 'Facilities Name is required',
            'facilities_icon.required' => 'Facilities Icon is required!'

        ];
    }
}
