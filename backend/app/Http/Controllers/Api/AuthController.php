<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{

    public function login(LoginRequest $request): JsonResponse
    {
        if (auth()->attempt($request->validated())) {
            $user = auth()->user();
            $token = $user->createToken('api-token')->plainTextToken;
            return response()->json([
                'message' => 'Успешный вход',
                'user' => $user,
                'token' => $token
            ]);
        }
        return response()->json(['message' => 'Неверные учетные данные'], 401);
    }

    public function logout(Request $request): JsonResponse
    {
        Cache::forget('cat_fact_'.$request->user()->id);
        auth('api')->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Успешный выход']);
    }

    public function user(): JsonResponse
    {
        return response()->json(['user' => auth()->user()]);
    }
}
