<?php

namespace App\Http\Resources;

use App\UserRole;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'badge' => $this->badge,
            'role' => new UserRoleResource($this->role)
        ];
    }
}
