<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AssignsDocumentResource extends JsonResource
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
            //'id' => $this->id,
            'name' => $this->name,
            'assignable_id' => $this->pivot->assignable_id,
            //'assignable_type' => $this->pivot->assignable_type,
            'assignable_type' => $this->pivot->assignable_type == 'App\Models\Department' ? 'department' : 'user',
            'remarks' => $this->pivot->remarks,
            'approved_at' => $this->pivot->approved_at,
            'disapproved_at' => $this->pivot->disapproved_at,
            'created_at' => (string) $this->pivot->created_at,
            'updated_at' => (string) $this->pivot->updated_at,
        ];
    }
}
