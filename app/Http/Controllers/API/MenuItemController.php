<?php

namespace App\Http\Controllers\API;

use App\Dish;
use App\MenuItem;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\MenuItemResource;
use App\Http\Requests\API\MenuItemRequest;
use App\Http\Resources\MenuResourceCollection;
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
        $collection = MenuItem::orderBy('menu_number')->with(['dish.type'])->get();

        return new MenuResourceCollection($collection);
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
        $dish = Dish::create([
            'dish_type_id' => $request->input('dishTypeId'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'name' => $request->input('name'),
        ]);

        $item = $dish->menuItem()->create([
            'menu_number' => $request->input('menuNumber'),
            'addition' => $request->input(['addition'])
        ]);

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
        $item = $menu->update([
            'menu_number' => $request->input('menuNumber'),
            'addition' => $request->input(['addition'])
        ]);

        $menu->dish()->update([
            'dish_type_id' => $request->input('dishTypeId'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'name' => $request->input('name'),
        ]);

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
