<?php
namespace App\Repositories\ApiToken;

interface ApiTokenRepositoryInterface
{
    public function validateToken(string $token): bool;

    public function getUserApiToken(int $userId);
}