<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RevisionFileResource extends JsonResource
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
            'user_id' => $this->user->name,
        ];
    }
}
