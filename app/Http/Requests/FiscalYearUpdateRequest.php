<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class FiscalYearUpdateRequest extends BaseFormRequest
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
            'year' => 'required',
            'active' => ''
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'select a year !!!',
            'year.required' => 'Please Enter Fiscal Year !!!'
        ];
    }

}
