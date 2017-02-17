<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/20/2016
 * Time: 3:56 PM
 */

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;

class AmenditiesEditRequest extends Request
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'amendities_name'   => 'required',

        ];
    }
    public function messages()
    {
        return [
            'amendities_name.required' => 'Amendities Name is required',


        ];
    }
}
