<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeMyPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class UserController extends MasterController
{
    function login(LoginRequest $request)
    {
        auth()->attempt($request->only('email', 'password'));
        $user = auth()->user();
        if ($user)
            $user->showToken = true;
        if ($user && $user->status != 'active')
            return response()->json(['status' => 400, 'msg' => 'هذا المستخدم غير مسموح له بالدخول تحدث مع الأدمن من أجل حل المشكلة']);
        return $this->response($user, new UserResource($user), ['status' => 400, 'msg' => 'Email Or Password InCorrect']);
    }

    function register(RegisterRequest $request)
    {
        $user = User::create($request->all());
        $role = $this->isAdmin() ? $request->role : 'user';
        $user->assignRole($role);
        if ($this->isAdmin() && $request->permissions)
            $user->syncPermissions(json_decode($request->permissions, true));
        $user->showToken = true;
        return response()->json(['status' => 200, 'data' => new UserResource($user)]);
    }
    function permissions()
    {
        return ['status' => 200, 'data' => Permission::pluck('name')];
    }
    function users()
    {
        $users = User::where('id', '!=', $this->user()->id)->get();
        return $this->response($users, ['status' => 200, 'data' => UserResource::collection($users)]);
    }
    function userNames()
    {
        return response()->json(['status' => 200, 'data' => User::all(['id', 'name'])]);
    }
    function getUser()
    {
        return  $this->user() ? new UserResource($this->user()) : ['status' => 400, 'msg' => 'قم بتسجيل الدخول اولاً'];
    }
    function setUserActive(User $user)
    {
        $user->update(['status' => 'active']);
        return response()->json(['status' => 200, 'msg' => 'تم تفعيل المستخدم']);
    }
    function setUserBlock(User $user)
    {
        $user->update(['status' => 'block']);
        return response()->json(['status' => 200, 'msg' => 'تم حظر المستخدم']);
    }

    function changeMyPassword(ChangeMyPasswordRequest $request)
    {
        $hashed = $this->user()->password;
        if (Hash::check($request->old_password, $hashed)) {
            $this->user()->update([
                'password' => $request->password
            ]);
            return response()->json(['status' => 200, 'msg' => 'تم تغيير كلمة السر']);
        }
        return response()->json(['status' => 400, 'msg' => 'كلمة السر القديمة غير صحيحة']);
    }
    function update(UserUpdateRequest $request, User $user)
    {
        $user->update($request->all());
        if ($request->role)
            $user->syncRoles($request->role);
        if ($request->permissions)
            $user->syncPermissions(json_decode($request->permissions, true));
        return response()->json(['status' => 200, 'msg' => 'تم تحديث المستخدم']);
    }
    function destroy(User $user)
    {
        if ($user->unitViolation->count())
            return response()->json(['status' => 400, 'msg' => 'قام هذا المستخدم بتسجيل مخالفات مرورية فلا يمكن حذفه لكن يمكنك حظره عن استخدام التطبيق']);
        $user->delete();
        return response()->json(['status' => 200, 'msg' => 'تم حذف المستخدم بنجاح']);
    }
}
