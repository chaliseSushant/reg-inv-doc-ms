<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleStoreRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'role' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Please Enter Title',
            'role.required' => 'Please Enter Role',
        ];
    }
}
