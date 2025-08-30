<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderApiResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product' => new ProductApiResource($this->whenLoaded('product')),
            'user_id' => $this->user_id,
            'address' => $this->whenLoaded('addresses'),
            'is_rated' => $this->is_rated,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
