<?php

namespace App\Http\Controllers\Api\V1;

use App\Data\V1\UserData;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\V1\StoreUserRequest;
use App\Services\Users\V1\CreateUserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/users/register",
     *     tags={"Register"},
     *     summary="Register a new user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="secret123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(StoreUserRequest $request, CreateUserService $createUserService)
    {
        return  $createUserService->execute(
            UserData::from(
                $request->only('name', 'email', 'password')
            )
        );
    }
}
