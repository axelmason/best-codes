<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService {
    public function userCreate($data)
    {
        User::create($data);
    }

    public function login($data) : bool
    {
        return Auth::attempt(['email' => $data['email'], 'password' => $data['password']]);
    }

    public function logout()
    {
        Auth::logout();
    }
}
