<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
     // Back-end logic for user registration
     public function register(Request $request)
     {
         $data = $request->validate([
             'name' => 'required|string',
             'email' => 'required|email|unique:users,email',
             'password' => 'required|min:5|confirmed',
         ]);
 
         $user = User::create([
             'name' => $data['name'],
             'email' => $data['email'],
             'password' => bcrypt($data['password']),
         ]);
 
         return response([
             'user' => $user,
             'token' => $user->createToken('api_token')->plainTextToken,
         ]);
     }
 
     // Back-end logic for user login
     public function login(Request $req)
     {
         $data = $req->validate([
             'email' => 'required|email',
             'password' => 'required|min:5',
         ]);
 
         if (!Auth::attempt($data)) {
             return response(['msg' => 'Invalid credentials'], 403);
         }
 
         return response([
             'user' => auth()->user(),
             'token' => auth()->user()->createToken('api_token')->plainTextToken,
         ], 200);
     }
 
     // Logout user
     public function logout()
     {
         auth()->user()->tokens()->delete();
         return response(['msg' => 'Logout successful'], 200);
     }
 
     // Get user information
     public function user()
     {
         return response(['user' => auth()->user()], 200);
     }
}
