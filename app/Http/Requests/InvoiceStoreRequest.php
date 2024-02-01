<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class InvoiceStoreRequest extends BaseFormRequest
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
        //$currentDateTime = Carbon::now();

        return [
            'invoice_number' => 'required',
            //'invoice_datetime' => 'required|after_or_equal:' . $currentDateTime->toDateString(),
            'attender_book_number' => '',
            'subject' => 'required',
            'receiver' => 'required',
            'invoice_remarks' => 'required'
            //'medium' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'invoice_number.required' => 'Please Enter Invoice Number !!!',
            //'invoice_datetime.required' => 'Please Enter Invoice Date Time !!!',
            'subject.required' => 'Please Enter Invoice Subject !!!',
            'receiver.required' => 'Please Enter a Receiver !!!',
            //'medium.required' => 'please Enter Medium !!!'
            'invoice_remarks' => 'Please Enter Remarks !!!'
        ];
    }
}
