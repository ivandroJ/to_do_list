<?php

namespace App\Http\Controllers\Api\V1;

use App\Data\V1\UserData;
use App\Http\Controllers\Controller;
use App\Services\Users\V1\CreateUserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request, CreateUserService $createUserService)
    {
        return  $createUserService->execute(
            UserData::from(
                $request->only('name', 'email', 'password')
            )
        );
    }
}
