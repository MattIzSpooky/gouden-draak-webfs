<?php

namespace App\Http\Resources;

use App\PromotionalDiscounts;
use Illuminate\Http\Resources\Json\JsonResource;

class DishResource extends JsonResource
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
            'active' => $this->activeDiscount(),
            'price' => $this->price,
            'description' => $this->description,
            'dishType' => new DishTypeResource($this->type)
        ];
    }
}
