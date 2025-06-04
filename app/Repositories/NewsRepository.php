<?php

namespace App\Repositories;

use App\Data\NewsData;
use DomainException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Spatie\LaravelData\DataCollection;

class NewsRepository
{
    private $newApiHttpRequest;


    public function __construct()
    {
        $this->newApiHttpRequest = Http::withHeader(
            'X-Api-Key',
            env('NEWS_API_KEY')
        );
    }

    public function getTopHeadlines($country = 'us', $category = null, $q = null, $pageSize = 10, $page = 1)
    {
        $params = [
            'country' => $country,
            'pageSize' => $pageSize,
            'page' => $page,

        ];

        if ($category) {
            $params['category'] = $category;
        }
        if ($q) {
            $params['q'] = $q;
        }

        try {
            return Cache::remember(
                'top-headlines-' . $country . '-' . $category . '-' . $q . '-' . $pageSize . '-' . $page,
                now()->addMinutes(10),
                function () use ($params) {
                    $response = $this->newApiHttpRequest->get(env('NEWS_API_URL_TOP'), $params);

                    if ($response->successful()) {
                        return NewsData::collect(
                            $response->json('articles', [])
                        );
                    }
                }
            );

        } catch (\Exception $e) {
            throw new DomainException('Error fetching top headlines: ' . $e->getMessage());
        }

        return null;
    }

    public function getEverything($pageSize = 10, $page = 1)
    {
        $params = [
            'pageSize' => $pageSize,
            'page' => $page,
        ];

        try {
            return Cache::remember(
                'news-every-' .  $pageSize . '-' . $page,
                now()->addMinutes(10),
                function () use ($params) {
                    $response = $this->newApiHttpRequest->get(env('NEW_API_URL_EVERYTHING'), $params);

                    if ($response->successful()) {
                        return NewsData::collect(
                            $response->json('articles', [])
                        );
                    }
                }
            );
        } catch (\Exception $e) {
            throw new DomainException('Error fetching top headlines: ' . $e->getMessage());
        }

        return null;
    }
}
