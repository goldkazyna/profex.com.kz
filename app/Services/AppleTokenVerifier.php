<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\JWK;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class AppleTokenVerifier
{
    private const APPLE_KEYS_URL = 'https://appleid.apple.com/auth/keys';

    public function verify(string $idToken): ?array
    {
        try {
            $keys = $this->getApplePublicKeys();
            $decoded = JWT::decode($idToken, $keys);

            if ($decoded->iss !== 'https://appleid.apple.com') {
                return null;
            }

            if ($decoded->aud !== config('services.apple.client_id')) {
                return null;
            }

            return [
                'email' => $decoded->email ?? null,
                'provider_id' => $decoded->sub,
            ];
        } catch (\Exception $e) {
            return null;
        }
    }

    private function getApplePublicKeys(): array
    {
        $jwks = Cache::remember('apple_jwks', 3600, function () {
            $response = Http::get(self::APPLE_KEYS_URL);
            return $response->json();
        });

        return JWK::parseKeySet($jwks, 'RS256');
    }
}
