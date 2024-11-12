<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function Login(Request $request){
      try{

          if(Auth::attempt($request->only('email','password'))){
            $user  = Auth::user();
            $token = $user->createToken('app')->accessToken;

            return response([
                'message' => "successfully Login",
                'token'   => $token,
                'user'    => $user
            ],200); //state code for success
          }

      }catch(Exception $e){
         return response(['message' => $e->getMessage()],400);
      }


      return response([
           'message' => 'Invalid Email Or  Pasword '
      ],401);

    }//end Login method

    
    public function Register(Request $request){

        try{

            $user = User::create([
                'name' => $request->name,
                'email'=> $request->email,
                'password'=> Hash::make($request->password)
            ]);

            $token = $user->createToken('app')->accessToken;

            return response([
             'message' => "Registration Successfull",
             'token'   => $token,
             'user'    => $user
            ],200);

        }catch(Exception $e){
             return response(['message' => $e->getMessage()],400);
        }


    }// end Register method


}
