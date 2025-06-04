<?php

namespace App\Http\Controllers;

use App\Services\News\GetTopNewsService;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function top(Request $request, GetTopNewsService $getTopNewsService)
    {
        return view('news.top', [
            'title' => 'Top News',
            'newsList' => $getTopNewsService->execute(
                $request->input('country', 'us'),
                $request->input('category', null),
                $request->input('q', null)
            ),
        ]);
    }
}
