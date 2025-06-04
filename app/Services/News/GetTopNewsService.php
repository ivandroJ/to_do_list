<?php

namespace App\Services\News;

use App\Repositories\NewsRepository;
use Spatie\LaravelData\DataCollection;

class GetTopNewsService
{
    private NewsRepository $newsApiRepository;

    public function __construct()
    {
        $this->newsApiRepository = new NewsRepository();
    }

    public function execute($country = 'us', $category = null, $q = null)
    {
        return $this->newsApiRepository->getTopHeadlines(
            $country,
            $category,
            $q
        );
    }
}
