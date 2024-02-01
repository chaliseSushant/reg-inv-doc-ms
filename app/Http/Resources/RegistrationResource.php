<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegistrationResource extends JsonResource
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
            'id' => $this->id,
            'sender' => $this->name,
            'medium' => $this->medium,
            'registration_number' => $this->registration_number,
            'registration_date' => $this->registration_date,
            'letter_number' => $this->letter_number,
            'invoice_number' => $this->invoice_number,
            'invoice_date' => $this->invoice_date,
            'user_id' => $this->user_id,
            'subject' => $this->subject,
            'remarks' => $this->remarks,
            'fiscal_year_id' => $this->fiscal_year_id,
            'service' => $this->service->title,
            'complete' => $this->complete,
            'urgency' => $urgency,
            'secrecy' => $secrecy,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'document_id' => ($document->pluck('id'))[0],
        ];
    }
}
