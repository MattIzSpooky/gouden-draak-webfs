<?php

namespace App\Http\Resources;

use App\Http\Resources\DishResource;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuItemResource extends JsonResource
{
    /**
     * @var array
     */
    protected static $using = [];

    /**
     * @param array $using
     * @return void
     */
    public static function using($using = [])
    {
        static::$using = $using;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->merge(static::$using);

        if ($this->dish->hasDiscount()) {
            foreach ($this->dish->discounts as $discount) {
                $from = $discount->valid_from->subDay();
                $till = $discount->valid_till->addDay();
                if (!empty(static::$using['orderCreation'])) {
                    if (static::$using['orderCreation']->between($from, $till)) {
                        $this->dish->price = $discount->price;
                    }
                } else {
                    if ($this->dish->activeDiscount()->count()) {
                        $this->dish->price = $this->dish->activeDiscount()->pluck('price')->first();
                    } else {
                        $this->dish->price = $this->dish->price;
                    }
                }
            }
        }

        return [
            'id' => $this->id,
            'menuNumber' => $this->menu_number,
            'addition' => $this->addition,
            'amount' => $this->whenPivotLoaded('order_items', function () {
                return $this->pivot->amount;
            }),
            'comment' => $this->whenPivotLoaded('order_items', function () {
                return $this->pivot->comment;
            }),
            'dish' => new DishResource($this->dish),
            'deletedAt' => $this->deleted_at
        ];
    }
}
