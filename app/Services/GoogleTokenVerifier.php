<?php

namespace App\Services;

use Google_Client;

class GoogleTokenVerifier
{
    public function verify(string $idToken): ?array
    {
        try {
            $client = new Google_Client();
            $allowedAudiences = array_filter([
                config('services.google.client_id'),
                config('services.google.ios_client_id'),
            ]);

            foreach ($allowedAudiences as $audience) {
                $payload = $client->verifyIdToken($idToken, $audience);
                if ($payload) {
                    return [
                        'email' => $payload['email'],
                        'provider_id' => $payload['sub'],
                    ];
                }
            }
        } catch (\Exception $e) {
            return null;
        }

        return null;
    }
}
