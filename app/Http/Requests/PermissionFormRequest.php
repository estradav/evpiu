<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionFormRequest extends FormRequest
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
                    'name'          => 'required|string|unique:permissions,name',
                    'description'   => 'required|string',
                ];
                break;
            case 'PATCH':
            case 'PUT':
                return [
                    'name'          => 'required|string|unique:permissions,name,' . $this->permission->id,
                    'description'   => 'required|string',
                ];
                break;
        }
    }
}
