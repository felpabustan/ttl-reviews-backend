<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
          return response([
            'message' => 'Invalid credentials',
          ], Response::HTTP_UNAUTHORIZED);
        }

        $request->session()->regenerate();
    
        return response()->json(
            [
              'status'  => true,
              'message' => 'User Logged In Successfully',
              'user'    => Auth::user()->only(
                  [
                  'id',
                  'name',
                  'email',
                  ]
              ),
            ], 200
        );
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function register(Request $request) 
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
    
        return response()->json([
            'message' => 'User registered successfully. Please verify your email.',
            'user' => $user,
        ]);
    }

    public function resetPassword()
    {
        // TODO: Implement resetPassword() method.
    }
    
    public function user()
    {
        return Auth::user();
    }
}