<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DocumentRegistrationInvoiceResource extends JsonResource
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
            'registrations' => $this->registrations ? DocumentRegistrationsResource::collection($this->registrations) : null,
            'invoices' => $this->invoices ? DocumentInvoicesResource::collection($this->invoices) : null,
        ];

    }
}
