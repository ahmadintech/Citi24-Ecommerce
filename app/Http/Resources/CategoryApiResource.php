<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryApiResource extends JsonResource
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
            'name' => $this->name,
            'category_image' => url('storage/' . $this->category_image), // assuming image is stored in storage folder
            'status' => $this->status,
            'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
            // If you have subcategories, you can include them here as well
            // 'subcategories' => CategoryApiResource::collection($this->whenLoaded('subCategories')),
        ];
    }
}
