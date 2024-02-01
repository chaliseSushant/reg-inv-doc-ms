<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class DistrictUpdateRequest extends BaseFormRequest
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
            'name' => 'required|unique:districts',
            'identifier' => 'required|unique:districts',
            'province_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'Select a District !!!',
            'name.required' => 'Please enter District name !!!',
            'province_id.required' => 'Please Select Province !!!',
            'name.unique' => 'District Name already exists !!!',
            'identifier.required' => 'Please enter Identifier !!!',
            'identifier.unique' => 'Identifier already exists !!!',
        ];
    }
}
