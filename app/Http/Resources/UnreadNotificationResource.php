<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UnreadNotificationResource extends JsonResource
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
            "id" => $this->id,
        "type" => explode("\\",$this->type)[2],
        //"notifiable_type": "App\\Models\\User",
        "notifiable_id" => $this->notifiable_id,
            "data" => $this->data,
        /*"data": {
        "registration_id": "32",
            "assign_remarks": "xyz",
            "subject": "subjectt"
        },*/
        //"read_at": null,
        "created_at" => (string) $this->created_at,
        "updated_at" => (string) $this->updated_at,
        ];
    }
}
