<?php
namespace App\Http\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;

class FrontendController extends Controller
{
    public function __invoke(ResponseFactory $response)
    {
        return $response->view('app');
    }
}
