<?php

namespace App\Http\Requests;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\JsonResponse;

class FiscalYearStoreRequest extends BaseFormRequest
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
            'year' => 'required',
            'active' => ''
        ];
    }

    public function messages()
    {
        return [
            'year.required' => 'Please Enter Fiscal Year !!!'
        ];
    }

}
