<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeMyPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends MasterController
{
    function login(LoginRequest $request)
    {
        auth()->attempt($request->only('email', 'password'));
        $user = auth()->user();
        if ($user)
            $user->showToken = true;
        if ($user->status == 'active')
            return $this->response($user, new UserResource($user), ['msg' => 'Email Or Password InCorrect']);
        return response()->json(['msg' => 'هذا المستخدم غير مسموح له بالدخول تحدث مع الأدمن من أجل حل المشكلة']);
    }

    function register(RegisterRequest $request)
    {
        $user = User::create($request->all());
        $role = $this->isAdmin() ? $request->role : 'user';
        $user->assignRole($role);
        $user->showToken = true;
        if ($user->status == 'active')
            return $this->response($user, new UserResource($user));
        return response()->json(['msg' => 'هذا المستخدم غير مسموح له بالدخول تحدث مع الأدمن من أجل حل المشكلة']);
    }

    function users()
    {
        $users = User::all();
        return $this->response($users, UserResource::collection($users));
    }
    function setUserActive(User $user)
    {
        $user->update(['status' => 'active']);
        return response()->json(['msg' => 'تم تفعيل المستخدم']);
    }
    function setUserBlock(User $user)
    {
        $user->update(['status' => 'block']);
        return response()->json(['msg' => 'تم حظر المستخدم']);
    }

    function changeMyPassword(ChangeMyPasswordRequest $request)
    {
        $hashed = $this->user()->password;
        if (Hash::check($request->old_password, $hashed)) {
            $this->user()->update([
                'password' => $request->password
            ]);
            return response()->json(['msg' => 'تم تغيير كلمة السر']);
        }
        return response()->json(['msg' => 'كلمة السر القديمة غير صحيحة']);
    }
    function update(UserUpdateRequest $request, User $user)
    {
        $user->update($request->all());
        if ($request->role)
            $user->assignRole($request->role);
        return response()->json(['msg' => 'تم تحديث المستخدم']);
    }
    function destroy(User $user)
    {
        $user->delete();
        return response()->json(['msg' => 'تم حذف المستخدم بنجاح']);
    }
}
