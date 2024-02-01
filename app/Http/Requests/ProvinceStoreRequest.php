<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProvinceStoreRequest extends BaseFormRequest
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
            'name' => 'required|unique:provinces',
            'identifier' => 'required|unique:provinces'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter Province Name !!!',
            'name.unique' => 'Province Name already exists !!!',
            'identifier.required' => 'Please enter Identifier !!!',
            'identifier.unique' => 'Identifier already exists !!!',
        ];
    }
}
