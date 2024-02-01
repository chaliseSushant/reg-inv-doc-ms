<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class RegistrationStoreRequest extends BaseFormRequest
{
    public function authorize()
    {
        return Auth::guard('api')->check();
    }

    /*public function validationData()
    {
        $dataJson = $this->all();
        return json_decode($dataJson['registration'], true);
    }*/

    public function rules()
    {
        $max_file_size = config('app.max_file_size');
        $max_uploaded_file_size = config('app.max_uploaded_file_size');

        $rules = [
            'attachments' => 'required|array|min:1|max_uploaded_file_size:'.$max_uploaded_file_size,
            'attachments.*' => 'required|distinct|file|mimes:jpg,jpeg,bmp,png,ppt,pptx,doc,docx,pdf,xls,xlsx|max:'.$max_file_size,
            'registration_remarks' => '',
            'sender' => 'required',
            'subject' => 'required',
            'letter_number' => '',
            'registration_date' => 'nullable|required_with:registration_number',
            'registration_number' => 'nullable|unique:registrations|required_with:registration_date',
            'invoice_date' => 'nullable|required_with:invoice_number',
            'invoice_number' => 'nullable|required_with:invoice_date',
            'service_id' => 'required',
            'secrecy' => 'required',
            'urgency' => 'required',
        ];

        if( $this->all('attachments')['attachments'] != null){
            $attachmentsCount = count($this->all('attachments')['attachments']);
            $rules = array_merge($rules,['files_name' => 'required|array|size:'. $attachmentsCount]);
        }

        return $rules;
    }


    public function messages()
    {
        $max_file_size = config('app.max_file_size');
        $max_uploaded_file_size = config('app.max_uploaded_file_size');

        return [
            'sender.required' => 'Please enter a name !!!',
            'registration_date.required_with' => 'Please enter Registration date !!!',
            'registration_number.required_with' => 'Please enter Registration number !!!',
            'registration_number.unique' => 'Registration number already taken !!!',
            'invoice_date.required_with' => 'Please enter Invoice date !!!',
            'invoice_number.required_with' => 'Please enter Invoice number !!!',
            'subject.required' => 'Please Enter Subject !!!',

            'attachments.*.mimes' => 'Invalid or corrupted file format !!!',
            'attachments.required' => 'Please add a document or a file !!!',
            'attachments.min' => 'The attachments must have at least 1 item !!!',
            'attachments.*.distinct' => 'Please select distinct files !!!',
            'attachments.max_uploaded_file_size' => 'All files to be uploaded should not exceed '.($max_uploaded_file_size/1024).' MegaBytes',
            'attachments.*.max' => 'Single File size must be below '.($max_file_size/1024).' MegaBytes',

            'service_id.required' => 'Please Select a Service !!!',
            'secrecy.required' => 'Please select a Attribute Secrecy !!!',
            'urgency.required' => 'Please select a Attribute Urgency !!!',
        ];
    }

}
