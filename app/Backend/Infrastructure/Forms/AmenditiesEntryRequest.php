<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/20/2016
 * Time: 3:56 PM
 */

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;

class AmenditiesEntryRequest extends Request
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'amendities_name'   => 'required',
            'amendities_icon'   => 'required | mimes:jpeg,jpg,png',
        ];
    }
    public function messages()
    {
        return [
            'amendities_name.required' => 'Amendities Name is required',
            'amendities_icon.required' => 'Amendities Icon is required!'

        ];
    }
}
