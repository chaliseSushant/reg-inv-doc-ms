<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FiscalYearResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //dd($request);
        return [
            'id' => $this->id,
            'year' => $this->year,
            'active' => $this->active,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            //'deleted_at' => $this->deleted_at
        ];
    }
}
