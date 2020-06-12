<?php

namespace App\Http\Controllers\API;

use App\Table;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TableResource;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.s
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return TableResource::collection(Table::all());
    }

    /**
     * Display a listing of the resource.s
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function history(Request $request, Table $table)
    {
        return TableResource::collection(Table::all());
    }
}
