<?php

namespace App\Http\Controllers\API;

use App\Order;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Requests\API\OrderRequest;
use App\Http\Requests\API\OrderFilterRequest;

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
     * Display a listing of the resource on a specified date range.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter(OrderFilterRequest $request)
    {
        /** @var Order */
        $orders = Order::query()
            ->whereNotNull('paid_at')
            ->whereBetween('created_at', [Carbon::parse($request->query('from')), Carbon::parse($request->query('to'))]);

        return OrderResource::collection($orders->paginate());
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
        $order = Order::create([
            'paid_at' =>
            Carbon::parse($request->input('paidAt'))
        ]);

        $items = $request->get('items');

        foreach ($items as $item) {
            $order->items()->attach($item['id'], ['amount' => $item['amount']]);
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

    /**
     * Update the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(OrderRequest $request, Order $order)
    {
        /** @var Order */
        $order->update(['paid_at' => Carbon::parse($request->input('paidAt'))]);
        $items = $request->get('items');

        $order->items()->detach();
        foreach ($items as $item) {
            $order->items()->attach($item['id'], ['amount' => $item['amount']]);
        }

        return (new OrderResource($order))->response();
    }
}
