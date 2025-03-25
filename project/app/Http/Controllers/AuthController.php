<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function register(RegisterRequest $request)
    {
        // Получаем только валидированные данные
        $data = $request->safe()->only(['name', 'email', 'password']);

        // Создаем пользователя
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        $token = $user->createToken('auth-token');

        return $this->success([
            'user' => $user,
            'token' => $token->plainTextToken
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->validated())) {
            abort(401, trans('auth.failed'));
        }

        // Создание токена
        $user = Auth::user();
        $token = $user->createToken('auth-token');

        return $this->success(['token' => $token->plainTextToken]);
    }

    /**
     * Display the specified resource.
     */
    public function logout()
    {
        Auth::user()->tokens()->delete();
        return $this->success(null, 204);
    }
}
