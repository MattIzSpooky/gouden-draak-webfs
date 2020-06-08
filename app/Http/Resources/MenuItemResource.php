<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuItemResource extends JsonResource
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
            'menuNumber' => $this->menu_number,
            'addition' => $this->addition,
            'amount' => $this->whenPivotLoaded('order_items', function () {
                return $this->pivot->amount;
            }),
            'dish' => new DishResource($this->dish),
            'deletedAt' => $this->deleted_at
        ];
    }
}
