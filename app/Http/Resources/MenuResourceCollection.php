<?php

namespace App\Http\Resources;

use App\MenuItem;
use Illuminate\Support\Collection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MenuResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->groupBy('dish.type.type')->mapToGroups(function (Collection $items, $key) {
                return [
                    collect([
                        'type' => $key,
                        'items' => $items->map(function (MenuItem $item) {
                            return new MenuItemResource($item);
                        })
                    ])
                ];
            })->flatten(1),
        ];
    }
}
