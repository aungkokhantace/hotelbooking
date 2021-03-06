<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/20/2016
 * Time: 3:56 PM
 */

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;

class FacilitiesEditRequest extends Request
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'facilities_name'   => 'required',

        ];
    }
    public function messages()
    {
        return [
            'facilities_name.required' => 'Facilities Name is required',


        ];
    }
}
