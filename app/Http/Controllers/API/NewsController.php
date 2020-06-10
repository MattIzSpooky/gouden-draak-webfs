<?php

namespace App\Http\Controllers\API;

use App\News;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\NewsRequest;
use App\Http\Resources\NewsResource;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class NewsController extends Controller
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
        return NewsResource::collection(News::orderBy('created_at', 'desc')->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewsRequest $request)
    {
        $news = News::create($request->only(['title', 'text']));

        return (new NewsResource($news))->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        return new NewsResource($news);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(NewsRequest $request, News $news)
    {
        return $news->update($request->only(['title', 'text']))
            ? $this->response->json(['message' => 'Successful updated'], Response::HTTP_OK)
            : $this->response->json(['message' => 'Something went wrong'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        return $news->delete()
            ? $this->response->json(['message' => 'Successful deleted'], Response::HTTP_OK)
            : $this->response->json(['message' => 'Something went wrong'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
