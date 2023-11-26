<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends MasterRequest
{

    public function rules(): array
    {
        $user = $this->route('user');
        return [
            'name'     => 'required|min:3',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'role'     => 'nullable|in:user,admin'
        ];
    }
}
