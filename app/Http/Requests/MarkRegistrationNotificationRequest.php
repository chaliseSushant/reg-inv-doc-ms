<?php

namespace App\Http\Requests;


use Illuminate\Support\Facades\Auth;

class MarkRegistrationNotificationRequest extends BaseFormRequest
{
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
            'notification_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'notification_id.required' => 'Enter a notification !!!',
        ];
    }
}
