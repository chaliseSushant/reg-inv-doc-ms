<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class PrivilegeUpdateRequest extends BaseFormRequest
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
            'name' => 'required|unique:privileges|max:255',
            //'identifier' => ''
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'Select a privilege',
            'name.required' => 'Please enter Privilege Name !!!'
        ];
    }
}
