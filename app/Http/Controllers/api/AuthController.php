<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\Auth\AuthService;

class AuthController extends Controller
{
    private $authService;
    public function __construct(AuthService $authService)
    {
      $this->authService =$authService;
    }
    public function register(RegisterRequest $request)
    {
        $user = $this->authService->create($request);
        $tokenResult=$this->authService->createAccessToken($user);
        return $this->authService->buildResponse($tokenResult , 'compte créer avec succès');
    }
}
