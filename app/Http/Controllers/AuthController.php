<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Traits\ApiResponser;

class AuthController extends Controller
{
    use ApiResponser;
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return $this->errorResponse('Invalid username or password', 401);
        }

        return $this->successResponse('Success', [
            'user' => auth()->user()->load('role'),
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function me()
    {
        return $this->successResponse('Success',auth()->user()->load('role'));
    }

    public function logout()
    {
        try {
            auth('api')->logout();
            return $this->successResponse('Success');
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => 'Token already expired or invalid'], 401);
        }
    }
}
