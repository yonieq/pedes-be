<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Login failed',
                'data' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Login failed',
                'data' => null
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $this->respondWithToken($token);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'nik' => 'required|unique:users,nik|digits:16|numeric',
        ]);

        $users = User::insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'nik' => $request->nik,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($users) {
            return response()->json([
                'success' => true,
                'message' => 'Register success',
                'data' => $users
            ], Response::HTTP_CREATED);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Register failed',
                'data' => null
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function me()
    {
        $users = auth()->user();

        return response()->json([
            'success' => true,
            'message' => 'User profile',
            'data' => $users
        ], Response::HTTP_OK);
    }

    public function logout()
    {
        $revokeToken = JWTAuth::invalidate(JWTAuth::getToken());

        if ($revokeToken) {
            return response()->json([
                'success' => true,
                'message' => 'Logout success',
                'data' => null
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Logout failed',
                'data' => null
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    private function respondWithToken($token)
    {
        return response()->json([
            'success' => true,
            'message' => 'Login success',
            'data' => [
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60
            ]
        ], Response::HTTP_OK);
    }
}