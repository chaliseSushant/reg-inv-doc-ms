<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoicesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $document = $this->documents;

        $document_attribute = ($document->pluck('attribute'))[0];

        switch (explode('-',$document_attribute)[0]) {
            case '1':
                $urgency = 'Important';
                break;
            case '2':
                $urgency = 'Very Important';
                break;
            case '3':
                $urgency = 'Urgent';
                break;
            default:
                $urgency = 'None';
                break;
        }

        switch (explode('-',$document_attribute)[1]) {
            case '1':
                $secrecy = 'Confidential';
                break;
            case '2':
                $secrecy = 'Top Secret';
                break;
            default:
                $secrecy = 'None';
                break;
        }

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
            "urgency" => $urgency,
            "secrecy" => $secrecy,
            "document_id" => ($document->pluck('id'))[0],

        ];
    }
}
