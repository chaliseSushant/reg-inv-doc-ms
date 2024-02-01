<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RolePermissionResource extends JsonResource
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
            'privileges' => PrivilegeResource::collection($this->privileges),
            'pivot' =>PivotCrudResource::collection($this->privileges),
        ];
    }
}
