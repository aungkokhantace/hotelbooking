<?php

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;

class HotelRoomTypeEditRequest extends Request
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
            'name'          => 'required|unique:h_room_type,name,'.$this->get('id').',id,deleted_at,NULL',
        ];
    }
    public function messages()
    {
        return [
            'name.required'         => 'Name is required!',
        ];
    }
}
