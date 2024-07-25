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
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id_category' => $this->id_category,
            'id_showroom' => $this->id_showroom,
            'images' => $this->images,
            'speed' => $this->speed,
            'type' => $this->type,
            'cylinder' => $this->cylinder,
            'color' => $this->color,
            'brand' => $this->brand,
            'model' => $this->model,
            'offer' => $this->offer,
        ];
    }
}
