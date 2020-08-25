<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostFormRequest extends FormRequest
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
     * @todo: Refactor rules to combine create and update requests.
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'         => 'required|string|max:256',
            'subtitle'      => 'required|string|max:100',
            'slug'          => 'required|string|unique:posts,slug|max:100',
            'body'          => 'required',
            'image'         => 'required',
            'categories'    => 'required',
            'tags'          => 'required',
        ];
    }
}
