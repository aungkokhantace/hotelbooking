<?php

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;

class SliderEntryRequest extends Request
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
        return [
            'template_id'       => 'required',
            'Title'             => 'required',
            'Description'       => 'required',
            'photo'             => 'required|dimensions:width=1600,height=675',
        ];
    }

    public function messages()
    {
        return [
            'template_id.required'       => 'Page is required!',
            'Title.required'             => 'Title is required!',
            'Description.required'       => 'Description is required!',
            'photo.required'             => 'Photo is required!',
            'photo.dimensions'           => 'Image width must be 1600 pixels and Height must be 675 pixels ',
        ];
    }
}
