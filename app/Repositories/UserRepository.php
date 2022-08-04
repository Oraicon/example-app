<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\User;

class UserRepository implements UserInterface
{
    public function selectUser($email)
    {
        return User::select('name', 'remember_token')
        ->where('email', $email)
        ->get();
    }

    public function createUser($request)
    {
        return User::create($request);
    }

    public function updateUser($token, $name)
    {
        return User::where('name', $name)
        ->update(['remember_token' => $token]);
    }
}
