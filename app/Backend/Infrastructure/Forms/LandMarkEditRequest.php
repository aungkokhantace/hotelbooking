<?php

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;
use App\Setup\Landmark\LandmarkRepository;
use Illuminate\Support\Facades\Input;

class LandMarkEditRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $landmarkRepo = new LandmarkRepository();
        $landmarkObj  = $landmarkRepo->getObjByID($this->get('id'));

        return [
          'name'          => 'required|unique:landmarks,name,'.$this->get('id').',id,township_id,'.Input::get('township').',latitude,'.Input::get('latitude').',longitude,'.Input::get('longitude').',deleted_at,NULL',
          'township'      => 'required',
          'latitude'      => 'required|numeric',
          'longitude'     => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'name.required'          => 'Name is required!',
            'name.unique'            => 'The township already exists!',
            'township.required'      => 'Township is required!',
            'latitude.required'      => 'Latitude is required!',
            'latitude.numeric'      => 'Latitude must be numeric!',
            'longitude.required'     => 'Longitude is required!',
            'longitude.numeric'     => 'Longitude must be numeric!',
        ];
    }
}
