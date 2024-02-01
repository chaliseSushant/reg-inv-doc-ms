<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       // $revision = new RevisionFileResource($this->revisions);
        //dd($revision);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'revision' => new RevisionFileResource($this->revisions[0]),
        ];
    }
}
