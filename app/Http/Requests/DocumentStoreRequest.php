<?php

namespace App\Http\Requests;


use Illuminate\Support\Facades\Auth;

class DocumentStoreRequest extends BaseFormRequest
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
        $max_file_size = config('app.max_file_size');
        $max_uploaded_file_size = config('app.max_uploaded_file_size');

        $rules = [
            'attachments' => 'required|array|min:1|max_uploaded_file_size:'.$max_uploaded_file_size,
            'attachments.*' => 'required|distinct|file|mimes:jpg,jpeg,bmp,png,ppt,pptx,doc,docx,pdf,xls,xlsx|max:'.$max_file_size,
            'document_title' => 'required',
            'document_number' => '',
            'document_remarks'=> '',
            'urgency' => 'required',
            'secrecy' => 'required',
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
            'attachments.*.mimes' => 'Invalid or corrupted file format !!!',
            'attachments.required' => 'Please add a document or a file !!!',
            'attachments.min' => 'The attachments must have at least 1 item !!!',
            'attachments.*.distinct' => 'Please select distinct files !!!',
            'attachments.max_uploaded_file_size' => 'All files to be uploaded should not exceed '.($max_uploaded_file_size/1024).' MegaBytes',
            'attachments.*.max' => 'Single File size must be below '.($max_file_size/1024).' MegaBytes',

            'urgency.required' => 'Select Urgency ',
            'secrecy.required' => 'Select Secrecy ',
            'document_title.required' => 'Please enter Document Title !!!'
        ];
    }
}
