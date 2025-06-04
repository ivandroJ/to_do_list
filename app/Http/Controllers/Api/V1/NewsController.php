<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\News\GetTopNewsService;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function top(Request $request, GetTopNewsService $getTopNewsService)
    {
        $newsList = $getTopNewsService->execute(
            $request->input('country', 'us'),
            $request->input('category', null),
            $request->input('q', null)
        );

        return response()->json($newsList);
    }
}
