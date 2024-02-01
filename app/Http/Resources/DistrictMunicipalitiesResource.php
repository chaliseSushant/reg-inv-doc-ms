<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DistrictMunicipalitiesResource extends JsonResource
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
            //'district' => $this->district->name,
            'identifier' => $this->identifier,
            //'created_at' => $this->created_at,
            //'updated_at' => $this->updated_at,
            //'deleted_at' => $this->deleted_at
        ];
    }
}
