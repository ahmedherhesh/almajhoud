<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeMyPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends MasterController
{
    function login(LoginRequest $request)
    {
        $auth = auth()->attempt($request->all());
        $user = auth()->user();
        $user->showToken = true;
        return $this->response($auth, new UserResource($user), 'Email Or Password InCorrect');
    }

    function register(RegisterRequest $request)
    {
        $user = User::create($request->all());
        $role = $this->isAdmin() ? $request->role : 'user';
        $user->assignRole($role);
        $user->showToken = true;
        return $this->response($user, new UserResource($user));
    }

    function index()
    {
        $users = User::all();
        return $this->response($users, UserResource::collection($users));
    }
    
    function changeMyPassword(ChangeMyPasswordRequest $request)
    {
        $hashed = $this->user()->password;
        if (Hash::check($request->old_password, $hashed)) {
            $this->user()->update([
                'password' => $request->password
            ]);
            return response()->json(['msg' => 'Your password has changed successfully']);
        }
        return response()->json(['msg' => 'Old password incorrect']);
    }
}
