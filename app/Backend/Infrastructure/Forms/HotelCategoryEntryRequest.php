<?php

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;

class HotelCategoryEntryRequest extends Request
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
            'category'      => 'required|unique:h_nearby_category,name,NULL,id,deleted_at,NULL',
            'description'      => 'required',
        ];
    }

    public function messages()
    {
        return [
            'category.required'     => 'Category is required!',
            'category.unique'       => 'The name has already been taken!',
            'description.required'  => 'Description is required!',
        ];
    }
}
