<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return $this->successCreateResponse($user, 1, 'User registered successfully');
    }

    public function login(LoginRequest $request)
    {
        $request->validate([

        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !password_verify($request->password, $user->password)) {

            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->successResponse([
                           "user_details" => [
                               "id" => $user->id,
                               "name" => $user->name,
                               "email" => $user->email

                           ],
                           "token" => $token
                       ]);

    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->successResponse([
                'message' => 'Successfully logged out'
            ]);
    }

}
