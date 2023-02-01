<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Services\UserService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    public function show($id)
    {
        return response()->json(User::find($id), 200);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function register(CreateUserRequest $request, UserService $service)
    {
        $service->userCreate($request->validated());

        $service->login($request->validated());

        return response()->json(["id" => auth()->user()->id], Response::HTTP_OK);
    }

    public function login(LoginUserRequest $request, UserService $service)
    {
        $is_login = $service->login($request->validated());

        if($is_login)
            return response()->json('', Response::HTTP_NO_CONTENT);

        return response()->json(['errors' => ['message' => "Email and password didn't match"]], Response::HTTP_UNAUTHORIZED);
    }

    public function logout(UserService $service)
    {
        $service->logout();

        return to_route('home');
    }
}
