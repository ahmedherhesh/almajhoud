<?php

namespace App\Http\Requests;


class RegisterRequest extends MasterRequest
{
    public function rules(): array
    {
        return [
            'name'     => 'required|min:3',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'status'   => 'nullable|in:active,block',
            'role'     => 'nullable|in:user,admin'
        ];
    }
}
