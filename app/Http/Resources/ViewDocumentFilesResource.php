<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ViewDocumentFilesResource extends JsonResource
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
            'name' => $this->name,
            'revision' => new ViewDocumentRevisionsResource($this->latest_revision),
        ];
    }
}
