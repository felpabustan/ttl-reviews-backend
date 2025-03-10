<?php

namespace App\Http\Controllers;

use App\Repositories\ApiToken\ApiTokenRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiKeyController extends Controller
{
    protected $apiTokenRepository;

    public function __construct(ApiTokenRepositoryInterface $apiTokenRepository)
    {
        $this->apiTokenRepository = $apiTokenRepository;
    }

    public function index()
    {
        $user = Auth::user();
        $tokens = $this->apiTokenRepository->getUserApiToken($user->id);

        return response()->json($tokens);
    }
}
