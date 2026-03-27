<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function socialLogin(Request $request)
    {
        $request->validate([
            'provider' => 'required|in:google,apple',
            'email' => 'required|email',
            'provider_id' => 'required|string',
        ]);

        $user = User::updateOrCreate(
            ['email' => $request->email],
            [
                'provider' => $request->provider,
                'provider_id' => $request->provider_id,
            ]
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
        ]);

        $request->user()->update($request->only(['language', 'theme']));

        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
