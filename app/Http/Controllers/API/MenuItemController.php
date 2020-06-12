<?php

namespace App\Http\Controllers\API;

use PDF;
use App\Dish;
use App\MenuItem;
use Illuminate\Http\Request;
use App\PromotionalDiscounts;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\MenuItemResource;
use App\Http\Requests\API\MenuItemRequest;
use App\Http\Resources\MenuResourceCollection;
use App\Http\Requests\API\MenuItemUpdateRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Http\Resources\PromotionalDiscountsResource;

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
     * All trashed items
     *
     * @return void
     */
    public function allWithThrashed()
    {
        $collection = MenuItem::withTrashed()->orderBy('menu_number')->with(['dish.type'])->get();

        return new MenuResourceCollection($collection);
    }

    /**
     * Filters out the request parameters for searching
     *
     * @param Request $request
     * @return void
     */
    public function filter(Request $request)
    {
        $collection = MenuItem::with('dish.type')->whereHas('dish', function ($query) use ($request) {
            $query->where('name', 'like', $request->query('query') . '%')->OrWhereHas('type', function ($query) use ($request) {
                $query->where('type', 'like', $request->query('query') . '%');
            });
        })->orWhere('menu_number', 'like', $request->query('query') . '%')
            ->get();

        return new MenuResourceCollection($collection);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
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
     * @param \App\MenuItem $menuItem
     * @return \Illuminate\Http\Response
     */
    public function show(MenuItem $menu)
    {
        return new MenuItemResource($menu);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\MenuItem $menuItem
     * @return \Illuminate\Http\Response
     */
    public function update(MenuItemUpdateRequest $request, MenuItem $menu)
    {
        $menu->update([
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
     * @param \App\MenuItem $menuItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(MenuItem $menu)
    {
        return $menu->delete()
            ? $this->response->json(['message' => 'Successful deleted'], Response::HTTP_OK)
            : $this->response->json(['message' => 'Something went wrong'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param \App\MenuItem $menuItem
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        /** @var MenuItem */
        $menu = MenuItem::withTrashed()->with('dish')->findOrFail($id);

        return $menu->restore()
            ? $this->response->json(['message' => 'Successful restored'], Response::HTTP_OK)
            : $this->response->json(['message' => 'Something went wrong'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Export the menu as an pdf doc.
     */
    public function export()
    {
        $data = [
            'menuItems' => MenuItem::with('dish.type')->get(),
            'discounts' => PromotionalDiscountsResource::collection(PromotionalDiscounts::active()->get())
        ];

        $pdf = PDF::loadView('menu', $data);

        return $pdf->download('menu.pdf');
    }
}
