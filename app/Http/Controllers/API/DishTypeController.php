<?php

namespace App\Http\Controllers\API;

use App\DishType;
use App\Http\Controllers\Controller;
use App\Http\Resources\DishTypeResource;

class DishTypeController extends Controller
{
    /**
     * @return void
     */
    public function __invoke()
    {
        return DishTypeResource::collection(DishType::all());
    }
}
