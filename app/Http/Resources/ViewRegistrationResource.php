<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ViewRegistrationResource extends JsonResource
{
    public function toArray($request)
    {
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
            'fiscal_year' => $this->fiscalYear->year,
            'service' => $this->service->title,
            'complete' => $this->complete,
            //'urgency' => $this->getUrgencyAttribute(),
            //'secrecy' => $this->getSecrecyAttribute(),
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            //'document' => new DocumentRegistrationResource($this->documents->first()),
        ];
    }
}
