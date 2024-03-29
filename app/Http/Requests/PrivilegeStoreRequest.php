<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class PrivilegeStoreRequest extends BaseFormRequest
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
            'name' => 'required|unique:privileges|max:255',
            //'identifier' => ''
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter Privilege Name !!!'
        ];
    }
}
