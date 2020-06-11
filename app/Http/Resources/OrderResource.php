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
        MenuItemResource::using(['orderCreation' => $this->created_at]);

        return [
            'id' => $this->id,
            'paidAt' => $this->paid_at === null ? null : $this->paid_at->toIso8601String(),
            'createdAt' => $this->created_at->toIso8601String(),
            'items' => MenuItemResource::collection($this->items, $this->created_at)
        ];
    }
}
