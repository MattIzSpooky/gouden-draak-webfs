<?php

namespace App\Http\Controllers\API;

use App\PromotionalDiscounts;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Http\Resources\PromotionalDiscountsResource;
use App\Http\Requests\API\PromotionalDiscountRequest;

class PromotionalDiscountsController extends Controller
{
    private $response;

    /**
     * Constructor
     *
     * @param ResponseFactory $response
     */
    public function __construct(ResponseFactory $response)
    {
        $this->response = $response;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /** @var PromotionalDiscounts */
        $discounts = PromotionalDiscounts::query()->orderBy('valid_till')->get();

        return PromotionalDiscountsResource::collection($discounts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PromotionalDiscountRequest $request)
    {
        /** @var PromotionalDiscounts */
        $discount = PromotionalDiscounts::create([
            'title' => $request->input('title'),
            'text' => $request->input('text'),
            'valid_from' => $request->input('validFrom'),
            'valid_till' => $request->input('validTill'),
            'price' => $request->input('price'),
        ]);

        $discount->dishes()->sync($request->input('dishes'));

        return (new PromotionalDiscountsResource($discount))->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PromotionalDiscounts  $promotionalDiscounts
     * @return \Illuminate\Http\Response
     */
    public function show(PromotionalDiscounts $discount)
    {
        return (new PromotionalDiscountsResource($discount))->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PromotionalDiscounts  $promotionalDiscounts
     * @return \Illuminate\Http\Response
     */
    public function update(PromotionalDiscountRequest $request, PromotionalDiscounts $discount)
    {
        /** @var PromotionalDiscounts */
        $updated = $discount->update([
            'title' => $request->input('title'),
            'text' => $request->input('text'),
            'valid_from' => $request->input('validFrom'),
            'valid_till' => $request->input('validTill'),
            'price' => $request->input('price'),
        ]);

        $discount->dishes()->sync($request->input('dishes'));

        return $updated
            ? $this->response->json(['message' => 'Successful updated'], Response::HTTP_OK)
            : $this->response->json(['message' => 'Something went wrong'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PromotionalDiscounts  $promotionalDiscounts
     * @return \Illuminate\Http\Response
     */
    public function destroy(PromotionalDiscounts $discount)
    {
        $discount->dishes()->detach();

        return $discount->delete()
            ? $this->response->json(['message' => 'Successful deleted'], Response::HTTP_OK)
            : $this->response->json(['message' => 'Something went wrong'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
