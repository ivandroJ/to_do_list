<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\NewsController;
use App\Http\Controllers\Api\V1\TodoTaskController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Middleware\ForceJsonResponse;
use App\Http\Middleware\isTodoTaskOwnerMiddleware;
use App\Http\Middleware\TokenAuthMiddleware;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->middleware(ForceJsonResponse::class)->group(function () {
    Route::prefix('todo-tasks')
        ->middleware(TokenAuthMiddleware::class)
        ->group(function () {
            Route::middleware(isTodoTaskOwnerMiddleware::class)->group(function () {
                Route::get('/{id}', [TodoTaskController::class, 'show']);
                Route::put('/{id}', [TodoTaskController::class, 'update']);
                Route::delete('/{id}', [TodoTaskController::class, 'destroy']);
            });

            Route::get('/', [TodoTaskController::class, 'index']);
            Route::post('/', [TodoTaskController::class, 'store']);
        })
    ;


    Route::post('auth', [AuthController::class, 'auth']);
    Route::post('/users/register', [UserController::class, 'store']);

    Route::get('/news/top', [NewsController::class, 'top']);
});
