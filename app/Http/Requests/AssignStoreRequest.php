<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class AssignStoreRequest extends BaseFormRequest
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
            'assign_type' => 'required',
            'assign_id' => 'required',
            'registration_id' => 'required',
            'assign_remarks' => 'required',
            //'subject' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'assign_id.required' => 'Select a assigned user or department !!!',
            'assign_type.required' => 'Select a assigned user or department !!!',
            'registration_id.required' => 'Please select a Registration !!!',
            'assign_remarks.required' => 'Please enter assign remarks !!!',
           // 'subject.required' => 'Please enter subject !!!',
        ];
    }
}
