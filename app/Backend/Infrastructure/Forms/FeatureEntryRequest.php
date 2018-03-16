<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/20/2016
 * Time: 3:56 PM
 */

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;

class FeatureEntryRequest extends Request
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name'           => 'required|unique:features,name,NULL,id,deleted_at,NULL',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'name.unique'   => 'The name has already been taken!',
        ];
    }
}
