<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Traits\CustomResponseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
   use CustomResponseTrait;
    public function login(LoginRequest $request)
    {


        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid username or password'], 401);
        }
        $data = $request->validated();

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Invalid username or password'], 401);
        }

        $token = $user->createToken('auth');
        
        return $this->custom_response(true, 'login Success', [
            'token' => $token->plainTextToken,
            'user' => $user
        ], 200);
    }
     
}
