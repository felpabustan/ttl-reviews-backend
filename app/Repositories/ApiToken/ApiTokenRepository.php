<?php
namespace App\Repositories\ApiToken;

use App\Models\ApiToken;

class ApiTokenRepository implements ApiTokenRepositoryInterface
{
    public function validateToken(string $token): bool
    {
        $processedToken = str_replace('Bearer ', '', $token);
        
        $apiToken = ApiToken::where('token', hash('sha256', $processedToken))->first();
        
        return $apiToken ? true : false;
    }

    public function getUserApiToken(int $userId)
    {
        return ApiToken::where('user_id', $userId)->get();
    }
}