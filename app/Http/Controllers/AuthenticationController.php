<?php

namespace App\Http\Controllers;

use App\Http\Requests\Administrator\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationController extends PersonalAccessToken
{
    public function login(LoginRequest $request): JsonResponse
    {
        $attempt = Auth::attempt($request->validated(), true);

        if ($attempt) {
            $user = Auth::user();
            //USER PERMISSIONS
            $permissions = $user->permissions()->pluck('name');
            $permissions = $permissions->map(fn($permission): array => ['action' => 'manage', 'subject' => $permission]);

            //USER ROLE
            $user->role = !empty($user->role) ? $user->role : $user->getRoleNames()->first() ?? null;

            $user->ability = array_merge(json_decode($user->ability), $permissions->toArray());

            //USER TOKEN
            $token = $user->createToken("cryoerp-$user->id");

            return jsonData(['accessToken' => $token->plainTextToken, 'userData' => $user]);
        } else {
            return jsonData(['message' => 'Invalid User.'], Response::HTTP_BAD_REQUEST);
        }
    }

    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        $response = $request->user('sanctum')->currentAccessToken()->delete();
        return jsonData(['message' => 'user logout', 'data' => $response]);
    }
}
