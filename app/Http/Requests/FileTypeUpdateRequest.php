<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class FileTypeUpdateRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard('api')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required',
            'name' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'Select a File type !!!',
            'name.required' => 'Please Enter Name !!!'
        ];
    }
}

