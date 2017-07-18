<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/20/2016
 * Time: 3:56 PM
 */

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;

class CommunicationEntryRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'reply'                      => 'required',
        ];
    }

    public function messages()
    {
        return [
            'reply.required'             => 'Reply Message is required!',
        ];
    }
}
