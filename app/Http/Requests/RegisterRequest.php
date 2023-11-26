<?php

namespace App\Http\Requests;


class RegisterRequest extends MasterRequest
{
    public function rules(): array
    {
        return [
            'name'     => 'required|min:3|max:255',
            'email'    => 'required|email|unique:users,email|max:255',
            'password' => 'required|min:6|max:255',
            'status'   => 'nullable|in:active,block|max:255',
            'role'     => 'nullable|in:user,admin|max:255'
        ];
    }
}
