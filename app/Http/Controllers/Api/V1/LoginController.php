<?php


namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class LoginController
{
    public function login(LoginRequest $request){
        if(Auth::attempt($request->only('email', 'password'))){
            return response()->json(Auth::user(), 201);
        }
        throw ValidationException::withMessages([
            'email' =>  ['Provided credentials are incorect']
        ]);
    }

    public function logout(){
        Auth::logout();
    }
}
