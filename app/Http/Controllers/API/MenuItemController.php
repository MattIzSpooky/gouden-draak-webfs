<?php

namespace App\Http\Controllers\API;

use App\Dish;
use App\MenuItem;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\MenuItemResource;
use App\Http\Requests\API\MenuItemRequest;
use Illuminate\Contracts\Routing\ResponseFactory;

class MenuItemController extends Controller
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
    public function index()
    {
        return ['data' => MenuItem::with(['dish.type'])->get()->groupBy('dish.type.type')];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuItemRequest $request)
    {
        /** @var Dish */
        $dish = Dish::create($request->only(['name', 'price', 'description', 'dish_type_id']));

        $item = $dish->menuItem()->create($request->only(['menu_number', 'addition']));

        return (new MenuItemResource($item))->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MenuItem  $menuItem
     * @return \Illuminate\Http\Response
     */
    public function show(MenuItem $menu)
    {
        return new MenuItemResource($menu);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MenuItem  $menuItem
     * @return \Illuminate\Http\Response
     */
    public function update(MenuItemRequest $request, MenuItem $menu)
    {
        $item = $menu->update($request->only(['menu_number', 'addition']));

        $menu->dish()->update($request->only(['name', 'price', 'description', 'dish_type_id']));

        return (new MenuItemResource($menu))->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MenuItem  $menuItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(MenuItem $menu)
    {
        $menu->delete();

        return Dish::find($menu->dish->id)->delete()
            ? $this->response->json(['message' => 'Successful deleted'], Response::HTTP_OK)
            : $this->response->json(['message' => 'Something went wrong'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
