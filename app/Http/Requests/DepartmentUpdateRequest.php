<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class DepartmentUpdateRequest extends BaseFormRequest
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
            'name' => 'required|unique:departments',
            'identifier' => 'required|unique:departments',
            'interconnect' => '',
        ];
    }



    public function messages()
    {
        return [
            'id.required' => 'Select a Department !!!',
            'name.required' => 'Please enter Department name !!!',
        ];
    }
}
