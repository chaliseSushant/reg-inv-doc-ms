<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
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
            'id' => $this->id,
            'title' => $this->title,
            'document_number' => $this->document_number,
            'remarks' => $this->remarks,
            'fiscal_year_id' => $this->fiscal_year_id,
            'urgency' => $this->getUrgencyAttribute(),
            'secrecy' => $this->getSecrecyAttribute(),
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
        ];
    }
}
