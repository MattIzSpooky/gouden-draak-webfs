<?php

namespace App\Http\Controllers\API;

use App\Order;
use App\Table;
use App\MenuItem;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Requests\API\OrderRequest;
use App\Http\Requests\API\OrderFilterRequest;
use App\Http\Requests\API\CustomerOrderRequest;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /** @var Order */
        $orders = Order::orderBy('created_at', 'desc')->paginate();

        return OrderResource::collection($orders);
    }

    /**
     * Display a listing of the resource on a specified date range.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter(OrderFilterRequest $request)
    {
        $from = Carbon::parse($request->query('from'))->subDay();
        $to = Carbon::parse($request->query('to'))->addDay();

        /** @var Order */
        $orders = Order::query()
            ->where('paid_at', '<>', null)
            ->whereBetween('paid_at', [$from, $to])
            ->get();

        return OrderResource::collection($orders);
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
        $order = Table::find($request->input('tableId'))->orders()->create([
            'paid_at' => Carbon::parse($request->input('paidAt'))
        ]);

        $items = $request->get('items');

        foreach ($items as $item) {
            $order->items()->attach($item['id'], [
                'amount' => $item['amount'],
                'comment' => $item['comment'] ?? null
            ]);
        }

        return (new OrderResource($order))->response();
    }

    /**
     * Store a newly created customer resource in storage.
     *
     * @param CustomerOrderRequest $request
     * @return void
     */
    public function storeCustomerOrder(CustomerOrderRequest $request)
    {
        /** @var Order */
        $order = Table::find($request->input('tableId'))->orders()->create([
            'paid_at' => null
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

        return (new OrderResource($order))->response();
    }
}
