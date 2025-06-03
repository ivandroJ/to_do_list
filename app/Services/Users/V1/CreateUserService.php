<?php

namespace App\Services\Users\V1;

use App\Data\V1\UserData;
use App\Models\User;

class CreateUserService
{

    public function execute(UserData $userData)
    {
        return $this->validate($userData) ?: response()->json([
            'message' => 'Usuario criado com sucesso.',
            'data' => UserData::from(
                User::create($userData->only('name', 'email', 'password')->toArray())
            )->exceptPermanently('password')
        ], 201);
    }

    private function validate(UserData $userData)
    {
        if (empty($userData->name)) {
            return response()->json([
                'message' => 'Name is required.',
                'errors' => [
                    'name' => 'Name is required.'
                ]
            ], 422);
        }

        if( strlen($userData->name) < 3 || strlen($userData->name) > 255) {
            return response()->json([
                'message' => 'Name must be between 3 and 255 characters long.',
                'errors' => [
                    'name' => 'Name must be between 3 and 255 characters long.'
                ]
            ], 422);
        }

        if (empty($userData->email)) {
            return response()->json([
                'message' => 'Email is required.',
                'errors' => [
                    'email' => 'Email is required.'
                ]
            ], 422);
        }

        if (User::where('email', $userData->email)->exists()) {
            return response()->json([
                'message' => 'Email already exists.',
                'errors' => [
                    'email' => 'Email already exists.'
                ]
            ], 422);
        }

        if (empty($userData->password)) {
            return response()->json([
                'message' => 'Password is required.',
                'errors' => [
                    'password' => 'Password is required.'
                ]
            ], 422);
        }

        if (strlen($userData->name) < 3 || strlen($userData->name) > 255) {
            return response()->json([
                'message' => 'Name must be between 3 and 255 characters long.',
                'errors' => [
                    'name' => 'Name must be between 3 and 255 characters long.'
                ]
            ], 422);
        }

        if (!filter_var($userData->email, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'message' => 'Invalid email format.',
                'errors' => [
                    'email' => 'Invalid email format.'
                ]
            ], 422);
        }

        if (strlen($userData->password) < 6) {
            return response()->json([
                'message' => 'Password must be at least 6 characters long.',
                'errors' => [
                    'password' => 'Password must be at least 6 characters long.'
                ]
            ], 422);
        }

        return null;
    }
}
