<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    /*  public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'username' => 'required|string|unique:users',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::login($user);

        return response()->json(['token' => $token], 201);
    }*/

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'O campo nome de usuário é obrigatório.',
            'username.string' => 'O campo nome de usuário deve ser uma string.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.string' => 'O campo senha deve ser uma string.',
        ]);

        $credentials = $request->only('username', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Login ou senha incorretos.'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Ocorreu um erro ao tentar fazer o login.'], 500);
        }

        return response()->json(['token' => $token]);
    }

    public function me()
    {
        return response()->json(JWTAuth::parseToken()->authenticate());
    }

    public function refreshToken(Request $request)
    {
        try {
            $currentToken = JWTAuth::getToken();

            if (!$newToken = JWTAuth::refresh($currentToken)) {
                return response()->json([
                    'error' => 'Não foi possível atualizar o token.',
                ], 500);
            }

            return response()->json([
                'token' => $newToken,
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Token inválido ou expirado.',
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        try {
            // Obtém o token do cabeçalho Authorization
            $token = JWTAuth::getToken();

            // Invalida o token
            JWTAuth::invalidate($token);

            return response()->json([]);
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Não foi possível realizar o logout.',
            ], 500);
        }
    }
}
