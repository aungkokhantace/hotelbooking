<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/20/2016
 * Time: 3:56 PM
 */

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Input;

class CityEntryRequest extends Request
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'country_id'         => 'required',
            'name'          => 'required|unique:cities,name,NULL,id,country_id,'.Input::get('country_id').',deleted_at,NULL',
            'photo'              => 'required'
        ];
    }
    public function messages()
    {
        return [
            'country_id.required'=> 'Country is required',
            'name.required'      => 'City Name is required!',
            'name.unique'        => 'City already exists!',
            'photo.required'     => 'Photo is required!'
        ];
    }
}
