<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'id_category' => $this->id_category,
            'id_showroom' => $this->id_showroom,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'images' => $this->images,
            'speed' => $this->speed,
            'type' => $this->type,
            'cylinder' => $this->cylinder,
            'color' => $this->color,
            'brand' => $this->brand,
            'model' => $this->model,
            'offer' => $this->offer,
            'image_link' => asset('storage/' . $this->images)
        ];
    }
}
