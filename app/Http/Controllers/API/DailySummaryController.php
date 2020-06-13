<?php

namespace App\Http\Controllers\API;

use App\DailySummary;
use App\Http\Controllers\Controller;
use App\Http\Resources\DailySummaryResource;
use Illuminate\Contracts\Routing\ResponseFactory;

class DailySummaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DailySummaryResource::collection(DailySummary::orderByDesc('date')->paginate());
    }

    /**
     * Downloads the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function download(DailySummary $summary, ResponseFactory $response)
    {
        $path = storage_path('app/summaries/' . $summary->file);

        return $response->download($path);
    }
}
