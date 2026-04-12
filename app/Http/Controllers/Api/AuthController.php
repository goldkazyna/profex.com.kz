<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\GoogleTokenVerifier;
use App\Services\AppleTokenVerifier;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function socialLogin(Request $request)
    {
        $request->validate([
            'provider' => 'required|in:google,apple',
            'token' => 'required|string',
        ]);

        $payload = match ($request->provider) {
            'google' => (new GoogleTokenVerifier())->verify($request->token),
            'apple' => (new AppleTokenVerifier())->verify($request->token),
        };

        if (!$payload || !$payload['email']) {
            return response()->json(['message' => 'Invalid token'], 401);
        }

        $user = User::updateOrCreate(
            ['provider' => $request->provider, 'provider_id' => $payload['provider_id']],
            ['email' => $payload['email']]
        );

        $token = $user->createToken('mobile')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'language' => 'sometimes|in:ru,kz',
            'theme' => 'sometimes|in:dark,light',
            'tax_rate' => 'sometimes|numeric|min:0|max:100',
        ]);

        $request->user()->update($request->only(['language', 'theme', 'tax_rate']));

        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
