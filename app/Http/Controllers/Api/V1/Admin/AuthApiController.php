<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AbilityResource;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class AuthApiController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]); 

        $credentials = request(['email', 'password']);
        if (!auth()->attempt($credentials)) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'password' => [
                        'Invalid credentials'
                    ],
                ]
            ], 422);
        }

        $user = User::where('email', $request->email)->first();
        $authToken = $user->createToken('auth-token')->plainTextToken;

        $user['access_token'] = $authToken;

        return response()->json($user);
    }

    public function getlogin()
    {
        $auth = Auth::user()->name;
    }
}
