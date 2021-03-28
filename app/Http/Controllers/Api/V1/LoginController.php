<?php


namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class LoginController
{
    public function login(LoginRequest $request){
        if(Auth::attempt($request->only('email', 'password'))){
            return new UserResource(Auth::user());
        }
        throw ValidationException::withMessages([
            'email' =>  ['Provided credentials are incorect']
        ]);
    }

    public function logout(){
        Auth::logout();
    }
}
