<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class ServiceUpdateRequest extends BaseFormRequest
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
            'title' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'Select a Service !!!',
            'title.required' => 'Please Enter Title',
        ];
    }
}
