<?php


namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Http\Resources\UserResource;

class UserController
{
    public function index()
    {
        return new UserResource(auth()->user());
    }
}
