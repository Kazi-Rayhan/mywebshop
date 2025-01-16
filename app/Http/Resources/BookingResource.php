<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
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
            'id'    => $this->id,
            'title' => 'Booking for ' . $this->manager->name,
            'customer' => $this->customer->fullname,
            'start' => $this->start_at->format('h:i A'),
            'end' => $this->end_at->format('h:i A'),
        ];
    }
}
