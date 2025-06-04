<?php

use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

Route::get('/news/top',[NewsController::class, 'top'])
    ->name('news.top');

Route::get('/', function () {
    return redirect("/api/documentation");
});
