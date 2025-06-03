<?php

namespace App\Services\Session;

use App\Data\V1\UserData;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class GenerateAuthTokenService
{
    private UserData $userData;

    public function execute(UserData $userData)
    {
        $this->userData = $userData;
        return $this->validate() ?: $this->generateToken();
    }

    private function validate()
    {

        if (empty($this->userData->email)) {
            return response()->json([
                'message' => 'Email is required.',
                'errors' => [
                    'email' => 'Email is required.'
                ]
            ], 422);
        }

        if (empty($this->userData->password)) {
            return response()->json([
                'message' => 'Password is required.',
                'errors' => [
                    'password' => 'Password is required.'
                ]
            ], 422);
        }

        return null;
    }


    private function generateToken()
    {
        $user = User::where('email', $this->userData->email)->first();

        if (! $user || ! Hash::check($this->userData->password, $user->password)) {
            return response()->json([
                'message' => 'The provided credentials are incorrect.',
                'errors' => [
                    'credentials' => 'The provided credentials are incorrect.'
                ]
            ], 422);
        }

        return response()->json([
            'token' => $user->createToken('api-token')->plainTextToken,
        ]);
    }
}
