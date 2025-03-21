<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'sometimes|in:client,agent,admin',
        ]);

        return response()->json($this->authService->register($validated), 201);
    }

    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        return response()->json($this->authService->login($validated));
    }

    public function logout(): JsonResponse
    {
        return response()->json($this->authService->logout());
    }

    public function getUser(): JsonResponse
    {
        return response()->json($this->authService->getUser());
    }
}
