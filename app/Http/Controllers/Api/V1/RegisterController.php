<?php


namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class RegisterController
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
                              'name' => $request->name,
                              'email' => $request->email,
                              'date_of_birth' => $request->date_of_birth,
                              'password' => Hash::make($request->password)
                            ]);

        $user->roles()->attach(Role::where('name', 'User')->first('id'));
    }
}
