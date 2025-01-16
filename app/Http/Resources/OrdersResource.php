<?php

namespace App\Http\Resources;

use App\Http\Resources\Api\ProductsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrdersResource extends JsonResource
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
            'discount' => $this->discount,
            'subtotal' => $this->subtotal,
            'tax' => $this->tax,
            'shipping_cost' => $this->shipping_cost,
            'total' => $this->total,
            'address' => [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'address' => $this->address,
                'city' => $this->city,
                'post_code' => $this->post_code,
                'phone' => $this->phone,
                'state' => $this->state,
                'details' => $this->details,
                'company_country_prefix' => $this->company_country_prefix,
                'company_name' => $this->company_name,
                'company_number' => $this->company_id,
            ],
            'user' => UsersResource::make($this->user),
            'payment' => [
                'id' => $this->payment_id,
                'url' => $this->payment_url,
                'method' => $this->payment_method,
                'status' => $this->payment_status == '1' ? 'PAID' : 'UNPAID',
                'currency' => $this->currency,
            ],
            'products' => $this->products->map(function ($product) {
                return [
                    'product' => [
                        'id' => $product->id,
                        'name' => $product->name,
                        'slug' => $product->slug,
                    ],
                    'quantity' => $product->pivot->quantity,
                    'price' => $product->pivot->price,
                ];
            }),
            'digital' => $this->is_digital ? True : False,

        ];
    }
}
