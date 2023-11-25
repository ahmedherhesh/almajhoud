<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeMyPasswordRequest extends MasterRequest
{
   
    public function rules(): array
    {
        return [
            'old_password' => 'required|min:6',
            'password' => 'required|min:6|confirmed'
        ];
    }
}
