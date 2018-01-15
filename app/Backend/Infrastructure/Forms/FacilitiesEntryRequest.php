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
            'name'              => 'required',
            'type'              => 'required',
            'facility_group'    => 'required',
            // 'photo'             => 'required'
        ];
    }
    public function messages()
    {
        return [
            'name.required'             => 'Facilities Name is required',
            'type.required'             => 'Type is required',
            'facility_group.required'   => 'Facility Group is required',
            // 'photo.required'            => 'Icon is required'
        ];
    }
}
