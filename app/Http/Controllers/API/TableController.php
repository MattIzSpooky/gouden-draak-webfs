<?php

namespace App\Http\Controllers\API;

use App\Table;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\TableResource;

class TableController extends Controller
{
    /**
     * Display a listing of the resources
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TableResource::collection(Table::all());
    }

    /**
     * Display a listing of the resources
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function history(Table $table)
    {
        /** @var Collection */
        $orders = $table->orders()->whereDate('created_at', now()->today())->latest()->get();

        return OrderResource::collection($orders);
    }
}
