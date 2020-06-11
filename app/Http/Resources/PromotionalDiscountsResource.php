<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PromotionalDiscountsResource extends JsonResource
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
            'title' => $this->title,
            'text' => $this->text,
            'validFrom' => $this->valid_from->toIso8601String(),
            'validTill' => $this->valid_till->toIso8601String(),
            'price' => $this->price,
            'dishes' => DishResource::collection($this->dishes)
        ];
    }
}
