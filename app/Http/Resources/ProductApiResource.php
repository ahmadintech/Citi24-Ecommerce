<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductApiResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->product_name,
            'price' => $this->price,
            'description' => $this->description,
            'rating' => $this->rating,
            'category' => new CategoryApiResource($this->whenLoaded('category')),
            'images' => $this->whenLoaded('images'),
            'attributes' => $this->whenLoaded('attributes'),
            'ratings' => $this->whenLoaded('ratings'),
        ];
    }
}
