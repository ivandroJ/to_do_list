<?php

namespace App\Http\Controllers\Api\V1;

use App\Data\V1\UserData;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Session\GenerateAuthTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function auth(Request $request, GenerateAuthTokenService $generateAuthTokenService)
    {

        return $generateAuthTokenService->execute(
            UserData::from([
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ])
        );
    }
}
