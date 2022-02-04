<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'data' => [
                'user_id' => $this->id,
                'phone_number' => $this->phone_number,
                'site' => $this->site,
                'department' => $this->department,
                'supervisor' => $this->supervisor_email,
            ]
        ];
    }
}
