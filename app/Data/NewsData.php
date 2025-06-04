<?php

namespace App\Data;

use DateTime;
use Spatie\LaravelData\Data;

class NewsData extends Data
{
    public function __construct(
        public ?array $source,
        public ?string $author,
        public ?string $title,
        public ?string $description,
        public ?string $url,
        public ?string $urlToImage,
        public ?DateTime $publishedAt,
        public ?string $content,
    ) {}
}
