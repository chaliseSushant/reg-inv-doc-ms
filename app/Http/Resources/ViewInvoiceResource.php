<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ViewInvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "invoice_number" => $this->invoice_number,
            "invoice_datetime" => (string) $this->invoice_datetime,
            "sender" => $this->sender,
            "attender_book_number" => $this->attender_book_number,
            "subject" => $this->sender,
            "receiver" => $this->receiver,
            "medium" => $this->medium,
            "remarks" => $this->remarks,
            "fiscal_year_id" => $this->fiscalYear->year,
            "created_at" => (string) $this->created_at ,
            "updated_at" => (string) $this->updated_at,
        ];
    }
}
