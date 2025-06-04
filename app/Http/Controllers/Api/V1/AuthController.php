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
    /**
     * @OA\Info(
     *     title="Todo List API",
     *     version="1.0.0",
     *     description="This is the API documentation for the Todo List application. It provides endpoints to manage todo tasks, including creating, retrieving, updating, and deleting tasks."
     * )
     *
     * @OA\Post(
     *     path="/api/v1/auth",
     *     tags={"Auth"},
     *     summary="Authenticate user and generate token",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="password", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful authentication",
     *         @OA\JsonContent(type="object", @OA\Property(property="token", type="string"))
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(type="object", @OA\Property(property="message", type="string"))
     *     )
     * )
     */
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
