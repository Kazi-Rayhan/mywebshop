<?php

namespace App\Http\Resources\Api;

use Iziibuy;
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
            'slug' => $this->slug,
            'sku' => $this->sku,
            'ean' => $this->ean,
            'item' => $this->item,
            'price' => $this->price,
            'saleprice' => $this->saleprice,
            'tax' => $this->tax,
            'details' => $this->details,
            'description' => $this->description,
            'quantity' => $this->quantity,  
            'categories' =>  CategoriesResource::collection($this->categories),
            'image' =>  Iziibuy::image($this->image),
            'variations' => ProductsResource::collection($this->variations),
            'variation' => $this->variation,
            'length'  => $this->length,
            'width' => $this->width,
            'height' => $this->height,
            'weight' => $this->weight,
        ];
    }
}
