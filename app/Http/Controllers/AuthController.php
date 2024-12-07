<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        if (! Auth::attempt($data)) {
            return response()->json([
                'message' => 'Неверный email или пароль'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = auth()->user();

        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'message' => 'Вход выполнен',
            'token' => $token
        ]);
    }


    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'message' => 'Регистрация выполнена',
            'token' => $token
        ], Response::HTTP_CREATED);
    }


    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Выход выполнен'
        ]);
    }
}
