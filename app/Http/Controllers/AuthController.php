<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    // Регистрация
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::query()->create($request->validated());

        return response()->json(['message' => "{$user['name']}, регистрация прошла успешно"], Response::HTTP_CREATED);
    }

    // Авторизация
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $token = $user->createToken('Personal Access Token')->plainTextToken;

            return response()->json(['token' => $token], Response::HTTP_OK)->cookie('token', $token, 60, '/api');
        }

        return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
    }

    // Выход пользователя
    public function logout(Request $request): JsonResponse
    {
        $user = auth()->user();
        $user->tokens()->delete();

        return response()->json(['message' => 'Successfully logged out'], Response::HTTP_OK);
    }
}
