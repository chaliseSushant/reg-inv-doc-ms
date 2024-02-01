<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class ProvinceUpdateRequest extends BaseFormRequest
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


    public function rules()
    {
        return [
            'id' => 'required',
            'name' => 'required|unique:provinces',
            'identifier' => 'required|unique:provinces'
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'Select a Province !!!',
            'name.required' => 'Please enter Province Name !!!',
            'name.unique' => 'Province Name already exists !!!',
            'identifier.required' => 'Please enter Identifier !!!',
            'identifier.unique' => 'Identifier already exists !!!',
        ];
    }
}
