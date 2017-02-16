<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/20/2016
 * Time: 3:56 PM
 */

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;

class FeatureEditRequest extends Request
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'feature_name'   => 'required',

        ];
    }
    public function messages()
    {
        return [
            'feature_name.required' => 'Feature Name is required',


        ];
    }
}
