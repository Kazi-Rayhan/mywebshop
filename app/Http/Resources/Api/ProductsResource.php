<?php

namespace App\Http\Resources\Api;

use Iziibuy;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResource extends JsonResource
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
            'image' => Iziibuy::image($this->image),
            'slug' => $this->slug,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'saleprice' => $this->saleprice,
            'tax' => $this->tax,
            'details' => $this->details,
            'categories' =>  CategoriesResource::collection($this->categories),

        ];
    }
}
