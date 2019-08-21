<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
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
        return [
            'name'                  => 'required|string|min:4',
            'email'                 => 'required|string|email|unique:users,email,'. $this->user->id ,
            'username'              => 'required|string|min:4|unique:users,username,'. $this->user->id ,
            'password'              => 'nullable|string|min:8|confirmed',
            'password_confirmation' => 'required_with:password',
        ];
    }
}
