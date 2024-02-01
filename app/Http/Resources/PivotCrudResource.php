<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PivotCrudResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'privilege_id' => $this->pivot->privilege_id,
            'role_id' => $this->pivot->role_id,
            'create' => $this->pivot->crud[0] == 1 ? true : false ,
            'read' => $this->pivot->crud[1] == 1 ? true : false ,
            'update' => $this->pivot->crud[2] == 1 ? true : false ,
            'delete' => $this->pivot->crud[3] == 1 ? true : false ,
        ];
    }
}
