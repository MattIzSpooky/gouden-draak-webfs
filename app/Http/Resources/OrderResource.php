<?php

namespace App\Http\Resources;

use App\MenuItem;
use App\Http\Resources\MenuItemResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $items = $this->items->transform(function (MenuItem $menuItem) {
            if ($menuItem->dish->hasDiscount()) {
                $from = $menuItem->dish->discounts->first()->valid_from->subDay();
                $till = $menuItem->dish->discounts->first()->valid_till->addDay();

                if ($this->created_at->between($from, $till)) {
                    $menuItem->dish->price = $menuItem->dish->actualPrice();
                }
            }
            return $menuItem;
        });

        return [
            'id' => $this->id,
            'paidAt' => $this->paid_at === null ? null : $this->paid_at->toIso8601String(),
            'createdAt' => $this->created_at->toIso8601String(),
            'items' => MenuItemResource::collection($items)
        ];
    }
}
