<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CodLineasFormRequest extends FormRequest
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
            'cod'           =>  'required|string|max:2|min:2',
            'name'          =>  'required|string|max:255',
            'abreviatura'   =>  'required|string|max:10',
            'coments'       =>  'string|max:256'
        ];
    }
}
