<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends BaseFormRequest
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
            'name'=>'required|max:255',
            'email'=>'required|email|unique:users|max:255',
            'password'=>'required|confirmed|min:8',
            'role_id' => 'required',
            'department_id' => 'required'
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'Please enter a Username',
            'name.max' => 'Username is too Long',
            'password.confirmed' => "Repeat Password doesn't match with Password",
            'role_id.required' => 'Please select a Role !!!',
            'department_id.required' => 'Please select a Department !!!'
        ];
    }
}
