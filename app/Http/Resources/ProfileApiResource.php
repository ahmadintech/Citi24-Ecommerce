<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address->address ?? null,
            'state' => $this->address->state?? null,
            'city' => $this->address->city ?? null,
            'is_primary' => $this->address->isPrimary ?? false,
          //  'created_at' => $this->created_at->toDateTimeString(),
          //  'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}