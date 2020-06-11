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
        /*$items = $this->items->transform(function (MenuItem $menuItem) {
            if ($menuItem->dish->hasDiscount()) {
                foreach ($menuItem->dish->discounts as $discount) {
                    $from = $discount->valid_from->subDay();
                    $till = $discount->valid_till->addDay();
                    if ($this->created_at->between($from, $till)) {
                        $menuItem->dish->price = $discount->price;
                    }
                }
            }
            return $menuItem;
        });*/

        MenuItemResource::using(['orderCreation' => $this->created_at]);

        return [
            'id' => $this->id,
            'paidAt' => $this->paid_at === null ? null : $this->paid_at->toIso8601String(),
            'createdAt' => $this->created_at->toIso8601String(),
            'items' => MenuItemResource::collection($this->items, $this->created_at)
        ];
    }
}
