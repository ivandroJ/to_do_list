@extends('layouts.news_page_layout')

@section('content')
    <div class="row">
        @foreach ($newsList as $news)
            <div class="col-12 mb-4">
                <div class="card tw-shadow-lg">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <img src="{{ $news->urlToImage }}" class="card-img-top" alt="{{ $news->title }}">
                            </div>
                            <div class="col-md-10">
                                <h2 class="card-title tw-text-xl tw-font-semibold">{{ $news->title }}</h2>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    <i class="fa fa-calendar"></i> {{ $news->publishedAt->format('Y-m-d H:i') }}
                                    <span class="tw-text-gray-500">by {{ $news->author }}</span>

                                </h6>
                                <p class="card-text">
                                    {{ $news->description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
@endsection
