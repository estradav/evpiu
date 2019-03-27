<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return TRUE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'name'          => 'required|string|unique:roles,name',
                    'description'   => 'required|string',
                    'permissions'   => 'required',
                ];
                break;
            case 'PATCH':
            case 'PUT':
                return [
                    'name'          => 'required|string|unique:roles,name,' . $this->role->id,
                    'description'   => 'required|string',
                    'permissions'   => 'required',
                ];
                break;
        }
    }
}
