<?php

namespace App\Domain\Repositories;

use App\Models\OAuthToken;

class OAuthRepository
{
    public function findByUserId(int $userId): ?OAuthToken
    {
        return OAuthToken::query()
            ->where('user_id', $userId)
            ->first();
    }

    public function store($response, int $userId)
    {
        return OauthToken::query()->updateOrCreate([
            'user_id' => $userId,
        ], [
            'user_id' => $userId,
            'token_type' => $response['token_type'],
            'expires_in' => $this->expired($response['expires_in']),
            'access_token' => $response['access_token'],
            'refresh_token' => $response['refresh_token'],
        ]);
    }

    public function expired($expires_in): string
    {
        return now()->addSeconds($expires_in)->format('Y-m-d H:i:s');
    }
}
