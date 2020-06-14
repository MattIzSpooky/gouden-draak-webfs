<?php

namespace App\Http\Resources;

use App\DailySummary;
use Illuminate\Http\Resources\Json\JsonResource;

class DailySummaryResource extends JsonResource
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
            'file' => $this->file,
            'date' => $this->date->toDateString(),
        ];
    }
}