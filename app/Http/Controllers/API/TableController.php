<?php

namespace App\Http\Controllers\API;

use App\Table;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TableResource;

class TableController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return TableResource::collection(Table::all());
    }
}
