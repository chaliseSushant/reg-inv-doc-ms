<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class DocumentAssignStoreRequest extends BaseFormRequest
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
            'assign_id' => 'required',
            'document_id' => 'required',
            'assign_remarks' => 'required',
            'assign_type' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'assign_id.required' => 'Whom to assign ?',
            'document_id.required' => 'Document Not Found !!!',
            'assign_remarks' => 'Please enter Remarks !!!',
            'assign_type' => 'select user or department !!!'
        ];
    }
}
