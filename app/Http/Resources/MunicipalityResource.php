<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MunicipalityResource extends JsonResource
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
            'district_id' => $this->district_id,
            'district' => $this->district->name,
            'identifier' => $this->identifier,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            //'deleted_at' => $this->deleted_at
        ];
    }
}
