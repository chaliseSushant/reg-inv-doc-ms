<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ServiceStoreRequest extends BaseFormRequest
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
            'title' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Please Enter Title',
        ];
    }
}
