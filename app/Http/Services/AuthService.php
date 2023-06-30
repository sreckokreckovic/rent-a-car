<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function login($email, $password)
    {
        $user = $this->getUserByCredentials($email, $password);
        if (!$user)
            return false;
        return $user->createToken('access_token')->plainTextToken;


    }

    public function getUserByCredentials($email, $password)
    {
        $user = \App\Models\User::query()->where('email', $email)->first();

        if ($user && Hash::check($password, $user->password))
            return $user;
        else
            return null;
    }
    public function logout(){
        auth()->user()->tokens()->delete();
    }

}


?>
