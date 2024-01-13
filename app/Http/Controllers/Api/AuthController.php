<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class AuthController extends Controller
{
    //back-end logic for register user
    public function register(Request $req){
        $data=$req->validate([
           'name'=>'required|string',
           'email'=>'unique|email|unique:users,email',
           'password'=>'required|min:5|confirmed'
        ]);
        $user=User::create(
            [
                'name'=>$data['name'],
                'email'=>$data['email'],
                'password'=>bcrypt($data['password'])
            ]
            );
            return response([
                'user'=>$user,
                'token'=>$user->createToken('secret')->plainTextToken,
            ]);
    }



    //back-end logic for register user
    public function login(Request $req){
        $data=$req->validate([
           'email'=>'unique|email',
           'password'=>'required|min:5'
        ]);
        if(!Auth::attempt($data)){
            
        }
        $user=User::create(
            [
                'name'=>$data['name'],
                'email'=>$data['email'],
                'password'=>bcrypt($data['password'])
            ]
            );
            return response([
                'user'=>$user,
                'token'=>$user->createToken('secret')->plainTextToken,
            ]);
    }
}
