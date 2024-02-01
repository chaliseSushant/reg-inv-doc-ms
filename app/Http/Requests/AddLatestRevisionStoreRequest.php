<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class AddLatestRevisionStoreRequest extends BaseFormRequest
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
        $max_file_size = config('app.max_file_size');
        return [
            'file_id' => 'required',
            'attachment' => 'required|file|mimes:jpg,jpeg,bmp,png,ppt,pptx,doc,docx,pdf,xls,xlsx|max:'.$max_file_size,
        ];
    }

    public function messages()
    {
        $max_file_size = config('app.max_file_size');
        return [
            'file_id.required' => 'File is required',
            'attachment.mimes' => 'Invalid or corrupted file format !!!',
            'attachments.required' => 'Please add a document or a file !!!',
            'attachment.max' => 'Single File size must be below '.($max_file_size/1024).' MegaBytes',

        ];
    }
}
