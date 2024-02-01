<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class MunicipalityStoreRequest extends BaseFormRequest
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
            'name' => 'required|unique:municipalities',
            'identifier' => 'required|unique:municipalities',
            'district_id' => 'required'
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'Please enter Municipality name !!!',
            'district_id.required' => 'Please Select District !!!',
            'name.unique' => 'Municipality Name already exists !!!',
            'identifier.required' => 'Please enter Identifier !!!',
            'identifier.unique' => 'Identifier already exists !!!',
        ];
    }
}
