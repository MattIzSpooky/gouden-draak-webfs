<?php

namespace App\Http\Controllers\API;

use App\MenuAddition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MenuAdditionResource;

class MenuAdditionController extends Controller
{
    /**
     *
     * @return void
     */
    public function __invoke()
    {
        return MenuAdditionResource::collection(MenuAddition::all());
    }
}
