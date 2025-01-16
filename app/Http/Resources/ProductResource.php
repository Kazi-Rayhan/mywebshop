<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use TCG\Voyager\Facades\Voyager;

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
            'category' => $this->category ?? $this->parent_categories->pluck('name')->join(' ,'),
            'sub_category' =>  $this->sub_categories->pluck('name')->join(' ,'),
            'sub_category2' =>  $this->sub_sub_categories->pluck('name')->join(' ,'),
            'image' => $this->image ? Voyager::image($this->image) : '',
            'is_variable' => $this->is_variable == '1' ? 'true' : 'false',
            'variation' => $this->variation,
            'length'  => $this->length,
            'width' => $this->width,
            'height' => $this->height,
            'weight' => $this->weight,
            'featured' => $this->featured == '1' ? 'true' : 'false',
            'status' => $this->status == '1' ? 'Active' : 'Deactive',
        ];
    }
}
