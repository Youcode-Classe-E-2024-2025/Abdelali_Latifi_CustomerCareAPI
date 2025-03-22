<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function register(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'] ?? 'client',
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }

    public function login(array $credentials)
    {
       $user = User::where('email', $credentials['email']);

       if(!$user || !Hash::check('password', $credentials['password'])){

        throw ValidationException::withMessages([
            'email' => ['incorrects informations .']
        ]);
       }
       $token = $user->createToken('auth_token')->plainTextToken;

       return ['user' => $user, 'token' => $token];
    }

    public function logout()
    {
       Auth::user()->tokens()->delete();   
       return ['message' => 'Logged out'];
    }

    public function getUser()
    {
        return Auth::user();
    }
}
