<?php

namespace App\Http\Controllers\API;

use App\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\OrderRequest;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return OrderResource::collection(Order::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        /** @var Order */
        $order = Order::create($request->only('paid_at'));
        $items = \json_decode($request->get('items'));

        foreach ($items as $item) {
            $order->items()->attach($item->id, ['amount' => $item->amount]);
        }

        return (new OrderResource($order))->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return new OrderResource($order);
    }
}
