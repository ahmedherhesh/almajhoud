<?php

namespace App\Http\Requests;


class LoginRequest extends MasterRequest
{
    public function rules(): array
    {
        return [
            'email'    => 'required|email|exists:users,email|max:255',
            'password' => 'required|min:6|max:255'
        ];
    }
}
