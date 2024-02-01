<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ViewDocumentRevisionsResource extends JsonResource
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
            'url' => url($this->url),
            'created_at' => (string) $this->created_at,
        ];
    }
}
