<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\GoogleTokenVerifier;
use App\Services\AppleTokenVerifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function socialLogin(Request $request)
    {
        $request->validate([
            'provider' => 'required|in:google,apple',
            'token' => 'required|string',
        ]);

        try {
            $payload = match ($request->provider) {
                'google' => (new GoogleTokenVerifier())->verify($request->token),
                'apple' => (new AppleTokenVerifier())->verify($request->token),
            };
        } catch (\Throwable $e) {
            Log::warning('Social token verify threw', [
                'provider' => $request->provider,
                'exception' => get_class($e),
                'message' => $e->getMessage(),
            ]);
            return response()->json([
                'message' => 'Invalid token',
                'debug' => get_class($e) . ': ' . $e->getMessage(),
            ], 401);
        }

        if (!$payload) {
            return response()->json([
                'message' => 'Invalid token',
                'debug' => 'verifier returned null',
            ], 401);
        }

        if (empty($payload['email'])) {
            return response()->json([
                'message' => 'Invalid token',
                'debug' => 'token valid but email claim missing (for Apple: email is only returned on first authorization — revoke the app in iOS Settings → Apple ID → Sign-in & Security → Sign in with Apple and retry)',
            ], 401);
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

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $token = $user->createToken('mobile')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)
            ->whereNull('provider')
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

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

    public function deleteAccount(Request $request)
    {
        $user = $request->user();

        $user->tokens()->delete();
        $user->incomes()->delete();
        $user->expenses()->delete();
        $user->employees()->delete();
        $user->categories()->delete();
        $user->delete();

        return response()->json(['message' => 'Account deleted']);
    }
}
